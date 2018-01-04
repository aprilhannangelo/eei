 CREATE TABLE employee_t(
   userid CHAR(20) NOT NULL,
   password VARCHAR(20) NOT NULL,
   first_name CHAR(30) NOT NULL,
   last_name CHAR(20) NOT NULL,
   user_type ENUM('Administrator', 'Employee') NOT NULL,
   email_address VARCHAR(50) NOT NULL,
   CONSTRAINT employee_pk PRIMARY KEY(userid)
 );

CREATE TABLE it_group_manager_t(
  userid CHAR(20) NOT NULL,
  password VARCHAR(20) NOT NULL,
  first_name CHAR(30) NOT NULL,
  last_name CHAR(20) NOT NULL,
  email_address VARCHAR(50) NOT NULL,
  group ENUM('Technical', 'Access', 'Network') NOT NULL,
  CONSTRAINT group_manager_t_pk PRIMARY KEY(userid)
);

CREATE TABLE ticket_agent_t(
  userid CHAR(20) NOT NULL,
  password VARCHAR(20) NOT NULL,
  first_name CHAR(30) NOT NULL,
  last_name CHAR(20) NOT NULL,
  email_address VARCHAR(50) NOT NULL,
  group ENUM('Technical', 'Access', 'Network') NOT NULL,
  position ENUM('Technician','Engineer') NOT NULL,
  CONSTRAINT ticket_agent_t_pk PRIMARY KEY(userid)
);

CREATE TABLE ticket_t(
  ticket_no INT(8) NOT NULL,
  requestor_userid CHAR(20) NOT NULL,
  ticket_agent_userid CHAR(20),
  it_group_manager_userid CHAR(20),
  date_prepared TIMESTAMP NOT NULL,
  date_Required TIMESTAMP,
  severity_level ENUM('SEV1', 'SEV2', 'SEV3', 'SEV4', 'SEV5'),
  ticket_type ENUM ('Technical','Access','Network') NOT NULL,
  remarks VARCHAR(100),
  resolution_date TIMESTAMP,
  activity_log VARCHAR(100),
  CONSTRAINT ticket_t_pk PRIMARY KEY(ticket_no),
  FOREIGN KEY(requestor_userid) REFERENCES employee_t(userid),
  FOREIGN KEY(ticket_agent_userid) REFERENCES ticket_agent_t(userid),
  FOREIGN KEY(it_group_manager_userid) REFERENCES it_group_manager_t(userid)
);

 CREATE TABLE notification_t(
   notification_id INT NOT NULL,
   userid CHAR(20) NOT NULL,
   first_name CHAR(30) NOT NULL,
   last_name CHAR(20) NOT NULL,
   email_address VARCHAR(50) NOT NULL,
   ticket_no INT(8) NOT NULL,
   notification_details VARCHAR(100) NOT NULL,
   CONSTRAINT notification_t_pk PRIMARY KEY(notification_id)
   FOREIGN KEY(userid) REFERENCES employee_t(userid), --madaming references tho??-
   FOREIGN KEY(first_name) REFERENCES employee_t(userid), --madaming references tho??-
   FOREIGN KEY(last_name) REFERENCES employee_t(userid), --madaming references tho??-
   FOREIGN KEY(email_address) REFERENCES employee_t(userid), --madaming references tho??-
 );

 CREATE TABLE service_ticket_t(
   request_details VARCHAR(200) NOT NULL,
   findings VARCHAR(200),
 );

 CREATE TABLE user_access_ticket_t(
   company VARCHAR(45) NOT NULL,
   department/project CHAR(20) NOT NULL,
   rc_no INT(5) NOT NULL,
   name TEXT NOT NULL,
   access_requested CHAR(40) NOT NULL,
   expiry_date TIMESTAMP,
   isChecked BOOLEAN,
   isApproved BOOLEAN
 );
