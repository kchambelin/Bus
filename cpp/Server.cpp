// This file is the server used to handle mutex and sockets.

#define WIN32_LEAN_AND_MEAN

#include <iostream>
#include <windows.h>
#include <winsock2.h>
#include <ws2tcpip.h>
#include <stdlib.h>
#include <stdio.h>
#include <thread>
#include <mutex>

std::mutex m;

class server;

struct thread_param {
    server* ser;
    SOCKET soc;
};

class server {
    private:
        int port;
        SOCKET ListeningSocket;
        bool running;
        SOCKADDR_IN ServerAddr;
        DWORD ClientThread(SOCKET);
    public:
        server(int);
        int init();
        int start();
        int pause();
        static DWORD WINAPI ThreadLauncher(void *p) {
            struct thread_param *Obj = reinterpret_cast<struct thread_param*>(p);
            server *s = Obj->ser;
            return s->ClientThread(Obj->soc);
        }
};

server::server(int p) {
    port = p;
    running = false;
}

int server::init() {
    struct in_addr MyAddress;
    struct hostent * host;
    char HostName[100];
    WSADATA wsaData;

    if(WSAStartup(MAKEWORD(2,2), &wsaData ) != 0 ){
        std::cerr << "WSAStartup failded" << std::endl;
        return 1;
    }
 
    if( gethostname( HostName, 100 ) == SOCKET_ERROR ){
        std::cerr<< "gethostname() a rencontré l'erreur "<< WSAGetLastError()  << std::endl;
        return 1;
    }
 
    if( (host = gethostbyname( HostName ) ) == NULL){
        std::cerr <<"gethostbyname() a rencontré l'erreur "<< WSAGetLastError()<< std::endl;
        return 1;
    }
 
    memcpy( &MyAddress.s_addr, host->h_addr_list[0], sizeof( MyAddress.s_addr ) );
 
    ServerAddr.sin_family = AF_INET;
    ServerAddr.sin_port = htons( port );    
    ServerAddr.sin_addr.s_addr = inet_addr( inet_ntoa( MyAddress ) );
 
    std::cout <<"server correctement initialisé" << std::endl;    
    return 0;  
}

int server::start() {
    SOCKADDR_IN ClientAddr;
    int ClientAddrLen;
    HANDLE hProcessThread;
    SOCKET NewConnection;
    struct thread_param p;
 
    if( ( ListeningSocket = socket( PF_INET, SOCK_STREAM, IPPROTO_TCP ) ) == INVALID_SOCKET ){
        std::cerr <<"ne peut créer la socket. Erreur n° " << WSAGetLastError()<< std::endl;
        WSACleanup();
        return 1;
    }

    if( bind( ListeningSocket, (SOCKADDR *)&ServerAddr, sizeof( ServerAddr ) ) == SOCKET_ERROR ){
        std::cerr<<"bind a échoué avec l'erreur "<< WSAGetLastError()<< std::endl;
        std::cerr<<"Le port est peut-être déjà utilisé par un autre processus "<< std::endl;
        closesocket( ListeningSocket );
        WSACleanup();
        return 1;
    }

    if( listen( ListeningSocket, 5 ) == SOCKET_ERROR ){
        std::cerr<<"listen a échoué avec l'erreur "<< WSAGetLastError()<< std::endl;
        closesocket( ListeningSocket );
        WSACleanup();
        return 1;
    }

    std::cout <<"serveur démarré : à l'écoute du port "<<port<< std::endl; 
    running = true;
    ClientAddrLen = sizeof( ClientAddr );
 
    while(running){
        if((NewConnection = accept( ListeningSocket, (SOCKADDR *) &ClientAddr, &ClientAddrLen)) == INVALID_SOCKET){
            std::cerr  <<"accept a échoué avec l'erreur "<< WSAGetLastError() << std::endl;;
            closesocket( ListeningSocket );
            WSACleanup();
            return 1;
        }

        p.ser = this;
        p.soc = NewConnection;
 
        std::cout << "client connecté ::  IP : "<<inet_ntoa( ClientAddr.sin_addr )<< " ,port = "<<ntohs( ClientAddr.sin_port )<< std::endl;
 
        hProcessThread = CreateThread(NULL, 0,&server::ThreadLauncher, &p,0,NULL);
        if ( hProcessThread == NULL ){                       
            std::cerr <<"CreateThread a échoué avec l'erreur "<<GetLastError()<< std::endl;
        }

    }   
    return 0;  
}

int server::pause() {
    running = false;
    std::cout << "Server paused" << std::endl;
    closesocket(ListeningSocket);
    return 0;
}

DWORD server::ClientThread(SOCKET soc) {
    std::cout << "Client Thread launched" << std::endl;
    m.lock();
    int iSendResult, iResult;
    iSendResult = send(soc, "1", iResult, 0);
        if (iSendResult == SOCKET_ERROR) {
            printf("send failed: %d\n", WSAGetLastError());
            closesocket(soc);
            WSACleanup();
            return 1;
        }
    m.unlock();
    return 0;
}

int main() {
    server *MyServer = new server(27015);
    if (MyServer->init() != 0) {
        std::cerr << "Couldn't initialize the server" << std::endl;
        return 1;
    }

    if (MyServer->start() != 0) {
        std::cerr << "Couldn't start the server" << std::endl;
        return 1;
    }

    return 0;
}