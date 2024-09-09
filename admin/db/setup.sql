use mbogodigital;

/* PART 1: DATABASE STRUCTURE */
CREATE TABLE `user`(
    `id` CHAR(36) NOT NULL,
    `duoNumber` INT NULL,
    `firstName` VARCHAR(50) NOT NULL,
    `prefix` VARCHAR(20) NULL,
    `lastName` VARCHAR(50) NOT NULL,
    `secret` VARCHAR(255) NULL,
    `email` VARCHAR(255) NOT NULL,
    `phone` VARCHAR(20) NULL,
    `changeSecretAtLogon` BOOLEAN NULL,
    `enabled` BOOLEAN NOT NULL,
    `roleId` CHAR(36) NULL,
    `educationId` CHAR(36) NULL,
    `cohort` BIGINT NULL,
    `creationDate` DATETIME NOT NULL,
    `modificationDate` DATETIME NOT NULL,
    PRIMARY KEY(`id`)
);
ALTER TABLE
    `user` ADD UNIQUE `user_email_unique`(`email`);
CREATE TABLE `education`(
    `id` CHAR(36) NOT NULL,
    `creboNumber` VARCHAR(20) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `level` INT NULL,
    `description` BLOB NULL,
    `registerUntil` DATE NULL,
    `graduateUntil` DATE NULL,
    PRIMARY KEY(`id`)
);
ALTER TABLE
    `education` ADD UNIQUE `education_crebonumber_unique`(`creboNumber`);
ALTER TABLE
    `education` ADD UNIQUE `education_name_unique`(`name`);
CREATE TABLE `keuzedeel`(
    `id` CHAR(36) NOT NULL,
    `code` VARCHAR(10) NOT NULL,
    `title` VARCHAR(100) NOT NULL,
    `sbu` INT NOT NULL,
    `description` BLOB NULL,
    `goalsDescription` BLOB NULL,
    `preconditions` BLOB NULL,
    `teachingMethods` BLOB NULL,
    `certificate` BOOLEAN NOT NULL,
    `linkVideo` VARCHAR(255) NULL,
    `linkKD` VARCHAR(255) NULL,
    PRIMARY KEY(`id`)
);
ALTER TABLE
    `keuzedeel` ADD UNIQUE `keuzedeel_code_unique`(`code`);
CREATE TABLE `levels`(
    `id` CHAR(36) NOT NULL,
    `educationId` CHAR(36) NOT NULL,
    `level` INT NOT NULL,
    `subject` VARCHAR(50) NOT NULL,
    `description` BLOB NOT NULL,
    `deliverables` BIGINT NOT NULL,
    PRIMARY KEY(`id`)
);
CREATE TABLE `role`(
    `id` CHAR(36) NOT NULL,
    `name` VARCHAR(30) NOT NULL,
    `level` INT NULL,
    PRIMARY KEY(`id`)
);
ALTER TABLE
    `role` ADD UNIQUE `role_name_unique`(`name`);
ALTER TABLE
    `levels` ADD CONSTRAINT `levels_educationid_foreign` FOREIGN KEY(`educationId`) REFERENCES `education`(`id`);
ALTER TABLE
    `user` ADD CONSTRAINT `user_educationid_foreign` FOREIGN KEY(`educationId`) REFERENCES `education`(`id`);
ALTER TABLE
    `user` ADD CONSTRAINT `user_roleid_foreign` FOREIGN KEY(`roleId`) REFERENCES `role`(`id`);

/* PART 2: DATA */
INSERT INTO `role` VALUES ('126c5a69-792c-427a-8bd9-0e20b8651f2b','Docent',20),('37914d3e-8e27-46e5-982f-30651d3276da','Applicatiebeheerder',80),('5482254d-709b-4f59-adf4-83d7f67d9553','Administrator',100),('6e27105c-c42a-46c8-9cd6-34ff1fe52572','Student',10);
INSERT INTO `education` VALUES ('6c93a885-9c11-4746-af76-b4b79ed3f1d0','25998','Software developer (vanaf 1-8-2024)',4,'',NULL,NULL),('6e606817-054b-4752-b801-0459dd8c2789','25604','Software developer',4,_binary 'Software ontwikkeling is een specialistisch vak. Desondanks dient de Software developer zich heel breed te oriënteren als het gaat om kennis en vaardigheden (zoals werkmethodieken, programmeertalen en de diverse informatiesystemen en platformen waar de programmatuur werkend moet zijn). Bovendien moet hij/zij breed onderlegd zijn daar waar het gaat om de enorme diversiteit aan mogelijke software en devices waar hij/zij mee te maken krijgt. Denk hierbij bijvoorbeeld aan het ontwikkelen van webbased software, websites, toepassingssoftware, games en andere entertainmentsoftware en media-uitingen.\r\n\r\nDe Software developer werkt voornamelijk zelfstandig aan het realiseren van software. De eindverantwoordelijkheid voor het eindproduct ligt vaak bij de projectleider of leidinggevende. In veel gevallen werkt hij/zij samen met andere disciplines, zoals andere developers en designers. Gedurende het ontwikkelproces heeft hij/zij bovendien regelmatig contact met de opdrachtgever/ leidinggevende/ belanghebbenden, wat specifieke eisen stelt aan communicatieve vaardigheden.\r\n\r\nDe Software developer werkt in vrijwel alle sectoren van de economie, zoals de brede ICT-sector, game-industrie, de creatieve sector, de logistieke sector, de mobiliteitsbranche, de maakindustrie, de zorg en nog veel meer. Binnen de sector waar hij/zij gaat werken moet hij/zij tevens breed onderlegd zijn met de voor die sector belangrijke ondersteunende kennis. Veelal is de beginnend beroepsbeoefenaar werkzaam in het midden- en kleinbedrijf.\r\n\r\nHet is van essentieel belang dat de Software developer de privacy van klanten, opdrachtgevers, en van alle (toekomstige) gebruikers van de software beschermt. Daarnaast moet software veilig zijn en beschermd zijn tegen oneigenlijk of crimineel gebruik.              ','2024-08-01','2030-08-01'),('8749f1bb-ac9c-41d8-8f80-cb6ccb413f7a','25605','Allround medewerker IT systems and devices',3,_binary 'De Allround medewerker IT systems and devices werkt zelfstandig op een ICT afdeling of in een servicedeskomgeving. Hij/zij werkt volgens standaard procedures en methodes en toont binnen vastgestelde kaders, eigen inzicht en initiatief. Hij/zij heeft goede communicatieve vaardigheden en werkt klantgericht.',NULL,NULL),('be7ee254-2ea6-45e3-860c-e762d54d04de','25606','Expert IT systems and devices',4,_binary 'De Expert IT systems and devices werkt zelfstandig op de ICT afdeling van een organisatie of in een servicedeskomgeving. Hij/zij heeft oog voor de organisatie en bezit een helikopterview. Hij/zij communiceert met alle betrokkenen.\r\n\r\nNaast het beheren van de IT infrastructuur, applicaties en devices houdt de Expert IT systems and devices zich bezig met het beveiligen van informatiesystemen. Hij/zij geeft security advies, verbetert de security van systemen en reageert op cybersecurity aanvallen. Ook heeft de Expert IT systems and devices een rol bij het communiceren over wensen van opdrachtgevers en het vertalen van deze wensen naar aanpassingen of vernieuwingen in de IT infrastructuur of applicaties. Het kunnen werken met databases en programmeerervaring speelt hierin een rol.',NULL,NULL),('d6ba472d-c84c-4b33-a6be-e1af53b32276','25999','Medewerker ICT (vanaf 1-8-2024)',2,'',NULL,NULL),('f0aa137e-3bd8-46b2-a716-c8bad5137a3c','25607','Medewerker ICT support',2,_binary 'De Medewerker ICT support werkt in opdracht en onder begeleiding van een leidinggevende. Hij/zij werkt in een weinig complexe omgeving en voert eenvoudige taken, routinematige en standaardwerkzaamheden uit. Hij/zij houdt zich daarbij strikt aan de geldende regels, instructies en procedures. Wanneer iets afwijkt van de opdracht overlegt hij/zij direct met de leidinggevende.\r\nDe Medewerker ICT support werkt op het gebied van hardware en devices. Het gaat bijvoorbeeld om het aanleggen, installeren en configureren van hardware en/of netwerken en het oplossen van storingen. Met betrekking tot devices voert de Medewerker ICT support activiteiten uit op het vlak van assemblage, reparatie, verlenen van service, geven van uitleg en (in sommige branches) verkoop van devices (zoals mobiele telefoons, tablets, laptops/notebooks, desktops, IoT devices, smart home devices, AV-apparatuur, VR/AR-devices en drones).','2024-08-01','2028-08-01');
INSERT INTO `user` VALUES ('23a4b3e7-9e01-47b7-b73a-ce7544379d89',0,'Test','van','Administrator','$2y$10$FuDLLcVEd.PE0I1QCJHZUej2JnVrSh/Y5vkKv.YphQkjaN7B/H2Yy','t.van.administrator@vistacollege.nl','0677778888',0,1,'5482254d-709b-4f59-adf4-83d7f67d9553','6e606817-054b-4752-b801-0459dd8c2789',2024,'2024-08-10 13:35:23','2024-08-10 13:35:23'),('2e71e52d-0d12-4ac5-9f06-1ece4190a30f',111222,'Test','van','Student','$2y$10$JwZm9zgLZDVC.i8sGiKywO0O0qgTuOnxYnT3k2AhwTnRYCYV/8C3O','t.van.student@vistacollege.nl','0611112222',0,1,'6e27105c-c42a-46c8-9cd6-34ff1fe52572','f0aa137e-3bd8-46b2-a716-c8bad5137a3c',2024,'2024-08-10 13:26:07','2024-08-10 13:26:24'),('8d2408cd-89cd-4c9c-95cc-9c97ae841a5f',0,'Test','van','Docent','$2y$10$/XL14jtCw5l.Xh8AgLbgm.bKkhK3NmsQ0V.7A6mtqlkjnTdjozyzS','t.van.docent@vistacollege.nl','0633334444',0,1,'126c5a69-792c-427a-8bd9-0e20b8651f2b','8749f1bb-ac9c-41d8-8f80-cb6ccb413f7a',2024,'2024-08-10 13:32:05','2024-08-10 13:32:05'),('c530cb1d-d60b-4a45-b066-892f040d5059',0,'Test','van','Applicatiebeheerder','$2y$10$jYDnL7r1Il.JTvewCdjvZewAedEWnqoZVBB4wJ.jtUeLJ/ULlsPkG','t.van.applicatiebeheerder@vistacollege.nl','0655556666',0,1,'37914d3e-8e27-46e5-982f-30651d3276da','be7ee254-2ea6-45e3-860c-e762d54d04de',2024,'2024-08-10 13:33:41','2024-08-10 13:33:57');