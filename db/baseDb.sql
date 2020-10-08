-- Project 1 Databse: Tournament Info Webapp

-- Create Base Tables
CREATE TABLE Player
(
  PlayerId int NOT NULL PRIMARY KEY,
  Playername varchar(60) NOT NULL,
  Picture varchar(256)
);

CREATE TABLE Character
(
  CharacterId int NOT NULL PRIMARY KEY,
  Charactername varchar(60) NOT NULL
);

CREATE TABLE Tournament
(
  TournamentId int NOT NULL PRIMARY KEY,
  TournamentName varchar(60),
  GamePlayed varchar(60),
  WinningPlayer int REFERENCES Player(PlayerId),
  WinningCharachter int REFERENCES Character(CharacterId)
);

CREATE TABLE Round
(
  RoundId int NOT NULL PRIMARY KEY,
  RoundName varchar(60)
);

-- Linking Tables
CREATE TABLE TournamentRound
(
  TournamentRoundId int NOT NULL PRIMARY KEY,
  TournamentId int REFERENCES Tournament(TournamentID),
  RoundId int REFERENCES Round(RoundId)
);

CREATE TABLE PlayerCharacterRound
(
  PlayerCharacterRoundId int NOT NULL PRIMARY KEY,
  PlayerId int REFERENCES Player(PlayerId),
  RoundId int REFERENCES Round(RoundId),
  CharacterId int REFERENCES Character(CharacterId)
);