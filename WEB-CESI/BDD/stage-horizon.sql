-- Suppression des tables si elles existent déjà (pour réinitialisation)
DROP TABLE IF EXISTS Favoris;
DROP TABLE IF EXISTS Candidature;
DROP TABLE IF EXISTS OffreStage;
DROP TABLE IF EXISTS Etudiant;
DROP TABLE IF EXISTS PilotePromotion;
DROP TABLE IF EXISTS Administrateur;
DROP TABLE IF EXISTS Entreprise;
DROP TABLE IF EXISTS Utilisateur;

-- Création des tables
CREATE TABLE Utilisateur (
    id_utilisateur INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL,
    prenom TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    mot_de_passe TEXT NOT NULL,
    role TEXT NOT NULL CHECK (role IN ('etudiant', 'pilote', 'admin'))
);

CREATE TABLE Entreprise (
    id_entreprise INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL,
    secteur TEXT,
    localisation TEXT,
    description TEXT
    note REAL,
);

CREATE TABLE Etudiant (
    id_etudiant INTEGER PRIMARY KEY AUTOINCREMENT,
    id_utilisateur INTEGER NOT NULL UNIQUE,
    mineure TEXT CHECK (mineure IN ('Informatique', 'S3E', 'BTP', 'Généraliste')),
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur)
);

CREATE TABLE PilotePromotion (
    id_pilote INTEGER PRIMARY KEY AUTOINCREMENT,
    id_utilisateur INTEGER NOT NULL UNIQUE,
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur)
);

CREATE TABLE Administrateur (
    id_admin INTEGER PRIMARY KEY AUTOINCREMENT,
    id_utilisateur INTEGER NOT NULL UNIQUE,
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur)
);

CREATE TABLE OffreStage (
    id_offre INTEGER PRIMARY KEY AUTOINCREMENT,
    id_entreprise INTEGER NOT NULL,
    id_pilote INTEGER NOT NULL,
    id_admin INTEGER NOT NULL,
    titre TEXT NOT NULL,
    description TEXT,
    competence TEXT,
    mineure TEXT CHECK (mineure IN ('Informatique', 'S3E', 'BTP', 'Généraliste')),
    base_remuneration REAL,
    date_debut TEXT,
    date_fin TEXT,
    nombre_candidatures INTEGER DEFAULT 0,
    FOREIGN KEY (id_entreprise) REFERENCES Entreprise(id_entreprise),
    FOREIGN KEY (id_pilote) REFERENCES PilotePromotion(id_pilote),
    FOREIGN KEY (id_admin) REFERENCES Administrateur(id_admin)
);

CREATE TABLE Candidature (
    id_candidature INTEGER PRIMARY KEY AUTOINCREMENT,
    id_etudiant INTEGER NOT NULL,
    id_offre INTEGER NOT NULL,
    date_candidature TEXT DEFAULT CURRENT_TIMESTAMP,
    cv TEXT NOT NULL,
    lettre_motivation TEXT,
    FOREIGN KEY (id_etudiant) REFERENCES Etudiant(id_etudiant),
    FOREIGN KEY (id_offre) REFERENCES OffreStage(id_offre),
    UNIQUE(id_etudiant, id_offre)
);

CREATE TABLE Favoris (
    id_favoris INTEGER PRIMARY KEY AUTOINCREMENT,
    id_etudiant INTEGER NOT NULL,
    id_offre INTEGER NOT NULL,
    FOREIGN KEY (id_etudiant) REFERENCES Etudiant(id_etudiant),
    FOREIGN KEY (id_offre) REFERE
    NCES OffreStage(id_offre),
    UNIQUE(id_etudiant, id_offre)
);

-- Insertion des données dans le bon ordre

-- 1. Utilisateurs de base
INSERT INTO Utilisateur (id_utilisateur, nom, prenom, email, mot_de_passe, role) VALUES
-- Administrateurs
(1, 'Dupont', 'Jean', 'admin1@ecole.fr', 'admin123', 'admin'),
(2, 'Martin', 'Sophie', 'admin2@ecole.fr', 'admin456', 'admin'),
-- Pilotes
(3, 'Leroy', 'Pierre', 'pierre.leroy@ecole.fr', 'pilote123', 'pilote'),
(4, 'Dubois', 'Marie', 'marie.dubois@ecole.fr', 'pilote456', 'pilote'),
(5, 'Moreau', 'Thomas', 'thomas.moreau@ecole.fr', 'pilote789', 'pilote'),
-- Étudiants
(6, 'Bernard', 'Lucas', 'lucas.bernard@ecole.fr', 'etud123', 'etudiant'),
(7, 'Petit', 'Emma', 'emma.petit@ecole.fr', 'etud456', 'etudiant'),
(8, 'Robert', 'Hugo', 'hugo.robert@ecole.fr', 'etud789', 'etudiant'),
(9, 'Richard', 'Léa', 'lea.richard@ecole.fr', 'etud012', 'etudiant'),
(10, 'Durand', 'Nathan', 'nathan.durand@ecole.fr', 'etud345', 'etudiant'),
(11, 'Simon', 'Chloé', 'chloe.simon@ecole.fr', 'etud678', 'etudiant'),
(12, 'Laurent', 'Mathis', 'mathis.laurent@ecole.fr', 'etud901', 'etudiant'),
(13, 'Michel', 'Camille', 'camille.michel@ecole.fr', 'etud234', 'etudiant'),
(14, 'Garcia', 'Enzo', 'enzo.garcia@ecole.fr', 'etud567', 'etudiant'),
(15, 'Fournier', 'Manon', 'manon.fournier@ecole.fr', 'etud890', 'etudiant'),
(16, 'Lefebvre', 'Louis', 'louis.lefebvre@ecole.fr', 'etud1234', 'etudiant'),
(17, 'Roux', 'Jade', 'jade.roux@ecole.fr', 'etud5678', 'etudiant'),
(18, 'Vincent', 'Paul', 'paul.vincent@ecole.fr', 'etud9012', 'etudiant'),
(19, 'Muller', 'Lina', 'lina.muller@ecole.fr', 'etud3456', 'etudiant'),
(20, 'Lemoine', 'Alexandre', 'alex.lemoine@ecole.fr', 'etud7890', 'etudiant');

-- 2. Profils spécifiques
INSERT INTO Administrateur (id_admin, id_utilisateur) VALUES
(1, 1),
(2, 2);

INSERT INTO PilotePromotion (id_pilote, id_utilisateur) VALUES
(1, 3),
(2, 4),
(3, 5);

INSERT INTO Etudiant (id_etudiant, id_utilisateur, mineure) VALUES
(1, 6, 'Informatique'),
(2, 7, 'Informatique'),
(3, 8, 'Informatique'),
(4, 9, 'Informatique'),
(5, 10, 'Informatique'),
(6, 11, 'S3E'),
(7, 12, 'S3E'),
(8, 13, 'S3E'),
(9, 14, 'S3E'),
(10, 15, 'S3E'),
(11, 16, 'BTP'),
(12, 17, 'BTP'),
(13, 18, 'BTP'),
(14, 19, 'BTP'),
(15, 20, 'Généraliste');

-- 3. Entreprises
INSERT INTO Entreprise (id_entreprise, nom, secteur, localisation, description) VALUES
(1, 'TechSoft', 'Informatique', 'Paris', 'Éditeur de logiciels innovants spécialisé dans les solutions SaaS'),
(2, 'GreenEnergy', 'Energie', 'Lyon', 'Leader des énergies renouvelables'),
(3, 'BatiPlus', 'BTP', 'Marseille', 'Entreprise générale de construction depuis 1985'),
(4, 'DataSphere', 'Informatique', 'Toulouse', 'Spécialiste du Big Data et IA'),
(5, 'EcoSolutions', 'Environnement', 'Nantes', 'Consultant en développement durable'),
(6, 'ConstructPro', 'BTP', 'Lille', 'Spécialiste rénovation bâtiments historiques'),
(7, 'WebFuture', 'Digital', 'Bordeaux', 'Agence web full-service'),
(8, 'Urbanis', 'Urbanisme', 'Strasbourg', 'Bureau d''études techniques'),
(9, 'InfoSys', 'Informatique', 'Rennes', 'ESN proposant services d''infogérance'),
(10, 'EnviroTech', 'Environnement', 'Nice', 'Start-up technologies propres');

-- 4. Offres de stage
INSERT INTO OffreStage (id_offre, id_entreprise, id_pilote, id_admin, titre, description, competence, mineure, base_remuneration, date_debut, date_fin) VALUES
-- Informatique
(1, 1, 1, 1, 'Développeur Full Stack', 'Développement applications web', 'JavaScript, React, Node.js', 'Informatique', 1200, '2023-06-01', '2023-12-31'),
(2, 4, 1, 1, 'Data Analyst', 'Analyse de données business', 'Python, SQL, Tableau', 'Informatique', 1100, '2023-07-01', '2024-01-31'),
-- S3E
(3, 2, 2, 1, 'Assistant Chef de Projet', 'Gestion projets énergies renouvelables', 'Gestion de projet, Excel', 'S3E', 1050, '2023-06-15', '2023-12-15'),
(4, 5, 2, 1, 'Consultant RSE', 'Conseil développement durable', 'RSE, Analyse cycle de vie', 'S3E', 950, '2023-07-01', '2023-12-31'),
-- BTP
(5, 3, 3, 2, 'Assistant Conducteur de Travaux', 'Suivi de chantier', 'Autocad, Excel', 'BTP', 1150, '2023-06-01', '2023-12-31'),
(6, 6, 3, 2, 'Technicien Méthodes', 'Optimisation process construction', 'Revit, BIM', 'BTP', 1100, '2023-07-01', '2023-12-31'),
-- Généraliste
(7, 7, 1, 2, 'Assistant Marketing Digital', 'SEO, réseaux sociaux', 'Réseaux sociaux, Analytics', 'Généraliste', 950, '2023-06-01', '2023-11-30'),
(8, 1, 2, 1, 'Assistant Communication', 'Communication interne/externe', 'Rédaction, Organisation', 'Généraliste', 900, '2023-07-01', '2023-12-31');

-- 5. Candidatures (chemins relatifs)
INSERT INTO Candidature (id_etudiant, id_offre, cv, lettre_motivation) VALUES
-- Étudiants en Informatique
(1, 1, 'cv/cv_lucas_bernard.pdf', 'lettre/lettre_lucas_techsoft_developpeur.pdf'),
(1, 2, 'cv/cv_lucas_bernard.pdf', 'lettre/lettre_lucas_datasphere_analyst.pdf'),
(2, 1, 'cv/cv_emma_petit.pdf', 'lettre/lettre_emma_techsoft_developpeur.pdf'),
-- Étudiants en S3E
(6, 3, 'cv/cv_chloe_simon.pdf', 'lettre/lettre_chloe_greenenergy_projet.pdf'),
(7, 4, 'cv/cv_mathis_laurent.pdf', 'lettre/lettre_mathis_ecosolutions_rse.pdf'),
-- Étudiants en BTP
(11, 5, 'cv/cv_louis_lefebvre.pdf', 'lettre/lettre_louis_batiplus_conducteur.pdf'),
(12, 6, 'cv/cv_jade_roux.pdf', 'lettre/lettre_jade_constructpro_methodes.pdf'),
-- Étudiants Généralistes
(15, 7, 'cv/cv_alexandre_lemoine.pdf', 'lettre/lettre_alexandre_webfuture_marketing.pdf'),
(15, 8, 'cv/cv_alexandre_lemoine.pdf', 'lettre/lettre_alexandre_techsoft_communication.pdf');

-- 6. Favoris
INSERT INTO Favoris (id_etudiant, id_offre) VALUES
(1, 1), (1, 2),
(2, 1), (2, 7),
(6, 3), (6, 4),
(11, 5), (11, 6),
(15, 7), (15, 8);

-- Mise à jour du nombre de candidatures
UPDATE OffreStage SET nombre_candidatures = (
    SELECT COUNT(*) FROM Candidature WHERE Candidature.id_offre = OffreStage.id_offre
);

-- Création des index
CREATE INDEX idx_candidature_etudiant ON Candidature(id_etudiant);
CREATE INDEX idx_candidature_offre ON Candidature(id_offre);
CREATE INDEX idx_favoris_etudiant ON Favoris(id_etudiant);
CREATE INDEX idx_favoris_offre ON Favoris(id_offre);
CREATE INDEX idx_offre_entreprise ON OffreStage(id_entreprise);
CREATE INDEX idx_offre_pilote ON OffreStage(id_pilote);
CREATE INDEX idx_offre_admin ON OffreStage(id_admin);

PRAGMA foreign_keys = ON;
