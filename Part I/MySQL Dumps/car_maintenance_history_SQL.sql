CREATE TABLE car_maintenance_history (
  VIN int(11) NOT NULL,
  Date date NOT NULL,
  Odometer int(11) NOT NULL,
  Maintenance varchar(40) NOT NULL,
  Description varchar(80) NOT NULL,
  primary key (VIN, Date, Odometer, Maintenance, Description));