CREATE TABLE reservations (
  ReservationID int(11) NOT NULL,
  MemberID int(11) NOT NULL,
  VIN int(11) NOT NULL,
  StartDate date NOT NULL,
  EndDate date NOT NULL,
  AccessCode int(11) NOT NULL
  primary key (ReservationID),
  foreign key (VIN) references Car (VIN),
  foreign key (MemberID) references KTCS_Member(MemberID));