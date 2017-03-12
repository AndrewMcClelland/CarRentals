CREATE TABLE parking_location (
  LocationID int(11) NOT NULL,
  AddressLine varchar(40) NOT NULL,
  PostalCode varchar(20) NOT NULL,
  Province varchar(30) NOT NULL,
  City varchar(40) NOT NULL,
  Country varchar(40) NOT NULL,
  Spaces int(11) NOT NULL,
  primary key (LocationID));