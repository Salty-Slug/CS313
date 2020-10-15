-- Project 1 Databse: Tournament Info Webapp

--DROP TABLES
DROP TABLE TournamentRound;
DROP TABLE PlayerCharacterRound;
DROP TABLE Tournament;
DROP TABLE Player;
DROP TABLE Character;
DROP TABLE Round;

-- Create Base Tables
CREATE TABLE Player
(
  PlayerId SERIAL NOT NULL PRIMARY KEY,
  Playername varchar(60) NOT NULL,
  Picture varchar(256)
);

CREATE TABLE Character
(
  CharacterId SERIAL NOT NULL PRIMARY KEY,
  Charactername varchar(60) NOT NULL
);

CREATE TABLE Tournament
(
  TournamentId SERIAL NOT NULL PRIMARY KEY,
  TournamentName varchar(60),
  GamePlayed varchar(60),
  WinningPlayer int REFERENCES Player(PlayerId)
);

CREATE TABLE Round
(
  RoundId SERIAL NOT NULL PRIMARY KEY,
  RoundName varchar(60),
  WinningPlayer int REFERENCES Player(PlayerId),
  WinningCharacter int REFERENCES Character(CharacterId)
);

-- Linking Tables
CREATE TABLE TournamentRound
(
  TournamentRoundId SERIAL NOT NULL PRIMARY KEY,
  TournamentId int REFERENCES Tournament(TournamentID),
  RoundId int REFERENCES Round(RoundId)
);

CREATE TABLE PlayerCharacterRound
(
  PlayerCharacterRoundId SERIAL NOT NULL PRIMARY KEY,
  PlayerId int REFERENCES Player(PlayerId),
  CharacterId int REFERENCES Character(CharacterId),
  RoundId int REFERENCES Round(RoundId)
);
