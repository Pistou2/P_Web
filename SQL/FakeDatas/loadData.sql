use db_p_web;

SELECT "" AS "Loading t_booktype";

LOAD DATA INFILE "G:/PROJETS/P_Web/Git-Web/SQL/FakeDatas/bookTypes.csv"
INTO TABLE t_booktype
CHARACTER SET 'utf8'
COLUMNS TERMINATED BY ";"
IGNORE 1 LINES
SET idBookType = NULL;


SELECT "" AS "Loading t_author";

LOAD DATA INFILE "G:/PROJETS/P_Web/Git-Web/SQL/FakeDatas/authors.csv"
INTO TABLE t_author
CHARACTER SET 'utf8'
COLUMNS TERMINATED BY ";"
IGNORE 1 LINES
SET idAuthor = NULL;

SELECT "" AS "Loading t_editor";

LOAD DATA INFILE "G:/PROJETS/P_Web/Git-Web/SQL/FakeDatas/editors.csv"
INTO TABLE t_editor
CHARACTER SET 'utf8'
COLUMNS TERMINATED BY ";"
IGNORE 1 LINES
SET idEditor = NULL;


SELECT "" AS "Loading t_user";

LOAD DATA INFILE "G:/PROJETS/P_Web/Git-Web/SQL/FakeDatas/users.csv"
INTO TABLE t_user
CHARACTER SET 'utf8'
COLUMNS TERMINATED BY ";"
IGNORE 1 LINES
SET idUser = NULL;


SELECT "" AS "Loading t_category";

LOAD DATA INFILE "G:/PROJETS/P_Web/Git-Web/SQL/FakeDatas/categories.csv"
INTO TABLE t_category
CHARACTER SET 'utf8'
COLUMNS TERMINATED BY ";"
IGNORE 1 LINES
SET idCategory = NULL;


SELECT "" AS "Loading t_books";

LOAD DATA INFILE "G:/PROJETS/P_Web/Git-Web/SQL/FakeDatas/books.csv"
INTO TABLE t_books
CHARACTER SET 'utf8'
COLUMNS TERMINATED BY ";"
IGNORE 1 LINES
SET idBook = NULL;


SELECT "" AS "Loading t_categorize";

LOAD DATA INFILE "G:/PROJETS/P_Web/Git-Web/SQL/FakeDatas/categorisations.csv"
INTO TABLE t_categorize
CHARACTER SET 'utf8'
COLUMNS TERMINATED BY ";"
IGNORE 1 LINES;

SELECT "" AS "Loading t_rating";

LOAD DATA INFILE "G:/PROJETS/P_Web/Git-Web/SQL/FakeDatas/ratings.csv"
INTO TABLE t_rating
CHARACTER SET 'utf8'
COLUMNS TERMINATED BY ";"
IGNORE 1 LINES;