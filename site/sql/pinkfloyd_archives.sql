-- =========================================================
-- Pink Floyd Archives: merch shop database
-- Run once:  mysql -u root -p < sql/pinkfloyd_archives.sql
-- (Re-running it resets the data back to these samples.)
-- =========================================================

DROP DATABASE IF EXISTS pinkfloyd_archives;
CREATE DATABASE pinkfloyd_archives;
USE pinkfloyd_archives;

-- ---------- Tables (names and columns exactly as the brief asks) ----------
CREATE TABLE Categories (
    categoryID   INT          NOT NULL AUTO_INCREMENT,
    categoryName VARCHAR(255) NOT NULL,
    PRIMARY KEY (categoryID)
);

CREATE TABLE Products (
    productID   INT           NOT NULL AUTO_INCREMENT,
    categoryID  INT           NOT NULL,
    productCode VARCHAR(10)   NOT NULL UNIQUE,   -- no two products share a code
    productName VARCHAR(255)  NOT NULL,
    listPrice   DECIMAL(10,2) NOT NULL,          -- DECIMAL, not FLOAT: exact money values
    PRIMARY KEY (productID),
    -- Foreign key: every product must belong to a real category
    FOREIGN KEY (categoryID) REFERENCES Categories (categoryID)
);

-- ---------- Sample data: 3 categories ----------
INSERT INTO Categories (categoryID, categoryName) VALUES
    (1, 'Vinyl'),
    (2, 'Apparel'),
    (3, 'Posters');

INSERT INTO Products (categoryID, productCode, productName, listPrice) VALUES
    (1, 'vdsotm',  'The Dark Side of the Moon (LP)',      49.99),
    (1, 'vwall',   'The Wall (2LP)',                      69.99),
    (1, 'vwywh',   'Wish You Were Here (LP)',             44.99),
    (1, 'vanimal', 'Animals (LP)',                        42.50),
    (1, 'vmeddle', 'Meddle (LP)',                         39.99),
    (2, 'tprism',  'Prism T-shirt',                       35.00),
    (2, 'hwall',   'The Wall Hoodie',                     79.00),
    (2, 'tpig',    'Animals Flying Pig T-shirt',          35.00),
    (2, 'cprism',  'Prism Beanie',                        29.95),
    (3, 'pdsotm',  'Dark Side Prism Poster (A2)',         24.99),
    (3, 'ppomp',   'Live at Pompeii Poster (A2)',         24.99),
    (3, 'pecho',   'Echoes Cover Art Print (A3)',         19.99),
    (3, 'pwall',   'The Wall Brick Poster (A1)',          29.99);

-- ---------- A dedicated database user ----------
-- The website logs in as this user, not as root. It can only read and change
-- data in THIS database (least privilege): it can't drop tables or touch other databases.
DROP USER IF EXISTS 'pfa_user'@'localhost';
CREATE USER 'pfa_user'@'localhost' IDENTIFIED BY 'shine0n';
GRANT SELECT, INSERT, UPDATE, DELETE ON pinkfloyd_archives.* TO 'pfa_user'@'localhost';
