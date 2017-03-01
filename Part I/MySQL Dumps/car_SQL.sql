CREATE TABLE car (
  VIN int(11) NOT NULL,
  Make varchar(15) NOT NULL,
  Model varchar(15) NOT NULL,
  Year int(11) NOT NULL,
  LocationID int(11) NOT NULL,
  Colour varchar(10) NOT NULL,
  PictureLink varchar(50) NOT NULL,
  RentalFee decimal(10,2) NOT NULL,
  primary key (VIN),
  foreign key (LocationID) references Parking_Location(LocationID));