create or replace view display_buses as with purchaised_places as (
    select
        bus_idbus,
        coalesce(
            count(
                idbook
            ), 0
        )as nb_places
    from
        books
    group by
        bus_idbus
) select 
    b.*,
    b.place_number - pp.nb_places as places_remaining
from
    bus b
    left join purchaised_places pp on pp.bus_idbus = b.idbus;
        