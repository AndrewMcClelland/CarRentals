CREATE TABLE car_rental_history (
  VIN int(11) NOT NULL,
  MemberID int(11) NOT NULL,
  PickupOdometer int(11) NOT NULL,
  DropoffOdometer int(11) NOT NULL,
  Status varchar(11) NOT NULL,
  Date date NOT NULL
  primary key (VIN, MemberID, PickupOdometer, DropoffOdometer, Status, Date));