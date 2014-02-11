

INSERT INTO clans_list ( clan_name, status, clan_tag ) VALUES 
( 'Spearhead', 1, 'SPQR' ), 
( 'Loyalist', 0, 'AUS' ), 
( 'Percival', 1, 'DND' ), 
( 'Revenant', 1, 'PwnStars' ), 

INSERT INTO players_list (`faf_id`, `status`,  `player_name`) VALUES
(1,  1, 'Lara Croft' ),
(2,  1, 'Max Payne' ),
(3,  1, 'Donkey Kong' ),
(4,  1, 'Gordon Freeman' ),
(5,  1, 'Adam Jensen' ),
(6,  1, 'The Nameless One' ),
(7,  1, 'Guybrush Threepwood' );

-- assumes the database tables have been created and populated from scratch, otherwise hardcoded IDs will not be correct.
INSERT INTO clan_members ( clan_id, player_id, clan_rank ) VALUES 
( 1, 1, 'Plebian'),
( 1, 2, 'Plebian'),
( 1, 4, 'Plebian');


