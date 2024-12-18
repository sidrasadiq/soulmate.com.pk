-- Create Database
CREATE DATABASE themillionaireso_soulmate

-- Create Roles Table
CREATE TABLE roles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    role_name VARCHAR(50) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_by INT,
    updated_by INT
    -- FOREIGN KEY (created_by) REFERENCES users(id),
    -- FOREIGN KEY (updated_by) REFERENCES users(id)
);

-- Create Users Table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role_id INT,
    is_verified TINYINT(1) DEFAULT 0,
    verification_token VARCHAR(255) NULL,
    otp VARCHAR(8) NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_by INT,
    updated_by INT,
    FOREIGN KEY (role_id) REFERENCES roles(id),
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
);
-- Create Cast Table
CREATE TABLE user_cast (
    id INT PRIMARY KEY AUTO_INCREMENT,
    cast_name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_by INT,
    updated_by INT,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
);

-- Create Qualifications Table
CREATE TABLE qualifications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    qualification_name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_by INT,
    updated_by INT,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
);

-- Create religion Table
CREATE TABLE religion (
    id INT PRIMARY KEY AUTO_INCREMENT,
    religion_name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_by INT,
    updated_by INT,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
);

-- Create Nationality Table
CREATE TABLE nationality (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nationality_name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_by INT,
    updated_by INT,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
);

-- Create Countries Table
CREATE TABLE countries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    country_name VARCHAR(100) NOT NULL UNIQUE,
    country_code VARCHAR(5) UNIQUE,  
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_by INT,
    updated_by INT,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
);

-- Create states table
CREATE TABLE states (
    id INT AUTO_INCREMENT PRIMARY KEY,
    state_name VARCHAR(100) NOT NULL,
    state_abbreviation VARCHAR(5) NOT NULL,
    country_id INT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_by INT,
    updated_by INT,
    FOREIGN KEY (country_id) REFERENCES countries(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
);

-- Create Cities Table
CREATE TABLE cities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    city_name VARCHAR(100) NOT NULL,
    state_id INT,
    country_id INT NOT NULL,
    zip_code VARCHAR(20),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_by INT,
    updated_by INT,
    FOREIGN KEY (country_id) REFERENCES countries(id) ON DELETE CASCADE,
    FOREIGN KEY (state_id) REFERENCES states(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
);

-- Dummy data for roles table. 
INSERT INTO `roles`(`role_name`, `description`, `created_at`, `updated_at`, `created_by`, `updated_by`) 
VALUES ('admin','Admin, who can manage every thing.',NOW() ,NOW(), 1, 1);

INSERT INTO `roles`(`role_name`, `description`, `created_at`, `updated_at`, `created_by`, `updated_by`) 
VALUES ('member','A member can create account on website and view the profiles of other members.',NOW() ,NOW(), 1, 1);

-- Dummy data for users table. 
INSERT INTO users(`username`, `email`, `password`, `role_id`, `is_active`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
('admin', 'admin@soulmate.com.pk', '$2y$10$8UxCHvWu4yZrfec4833eNeyk4KjKgzjYS004fs7iP3knp8eULtQda', 1, TRUE, NOW(), NOW(), 1, 1);

-- Adding foreign key to roles table.
ALTER TABLE roles
ADD CONSTRAINT fk_roles_created_by FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
ADD CONSTRAINT fk_roles_updated_by FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL;

CREATE TABLE profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    gender ENUM('male', 'female', 'other') NOT NULL,
    date_of_birth DATE,
    bio TEXT,
    profile_picture VARCHAR(255),
    profile_picture_2 VARCHAR(255),
    profile_picture_3 VARCHAR(255),
    profile_picture_4 VARCHAR(255),
    profile_picture_5 VARCHAR(255),
    country_id INT,
    city_id INT,
    contact_number VARCHAR(15),
    whatsapp_contact VARCHAR(15),
    cnic VARCHAR(15) UNIQUE,
    social_links JSON,
    cast_id INT,
    nationality_id INT,
    religion_id INT,
    qualification_id INT,
    last_university_name VARCHAR(255),
    interests TEXT,
    preferences TEXT,
    marital_status ENUM('single', 'married', 'separated', 'widowed', 'divorced', 'other', 'prefer not to say') NOT NULL,
    my_appearance ENUM('below average', 'average', 'attractive', 'very attractive', 'prefer not to say') NOT NULL,
    body_type ENUM('petite', 'slim', 'average', 'few extra pounds', 'full figured', 'large and lovely', 'prefer not to say') NOT NULL,
    drinkAlcohol ENUM('do drink','occasionally drink','do not drink','prefer not to say') NOT NULL, 
    smoking ENUM('do smoke','occasionally smoke','do not smoke','prefer not to say') NOT NULL, 
    children ENUM('yes','not sure','no','prefer not to say') NOT NULL,
    state_id INT,
    is_house_rented BOOLEAN NOT NULL,
    house_address VARCHAR(1000) NOT NULL,
    height INT,
    weight INT,
    dietary_preferences TEXT,
    education_level_id INT,
    -- occupation_id INT,
    annual_income INT,
    family_background TEXT,
    living_arrangements ENUM('with_family', 'alone'),
    mother_tongue VARCHAR(50),
    is_employed BOOLEAN DEFAULT FALSE,
    employment_place VARCHAR(100),
    designation VARCHAR(100),
    salary INT,
    employment_address VARCHAR(255),
    company_name VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_by INT,
    updated_by INT,
    is_profile_complete BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (country_id) REFERENCES countries(id) ON DELETE SET NULL,
    FOREIGN KEY (city_id) REFERENCES cities(id) ON DELETE SET NULL,
    FOREIGN KEY (cast_id) REFERENCES user_cast(id) ON DELETE SET NULL,
    FOREIGN KEY (nationality_id) REFERENCES nationality(id) ON DELETE SET NULL,
    FOREIGN KEY (religion_id) REFERENCES religion(id) ON DELETE SET NULL,
    FOREIGN KEY (qualification_id) REFERENCES qualifications(id) ON DELETE SET NULL,
    FOREIGN KEY (state_id) REFERENCES states(id) ON DELETE SET NULL,
    -- FOREIGN KEY (occupation_id) REFERENCES occupations(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE requirements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    profile_id INT,
    preferred_age_from INT,
    preferred_age_to INT,
    preferred_marital_status ENUM('single', 'married', 'separated', 'widowed', 'divorced', 'other', 'prefer not to say'),
    preferred_living_arrangement ENUM('with_family', 'alone'),
    preferred_education_level_id INT,
    preferred_country_id INT,
    preferred_state_id INT,
    preferred_city_id INT,
    preferred_cast_id INT,
    looking_for ENUM('male', 'female', 'other'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (profile_id) REFERENCES profiles(id) ON DELETE CASCADE,
    FOREIGN KEY (preferred_education_level_id) REFERENCES qualifications(id) ON DELETE SET NULL,
    FOREIGN KEY (preferred_country_id) REFERENCES countries(id) ON DELETE SET NULL,
    FOREIGN KEY (preferred_state_id) REFERENCES states(id) ON DELETE SET NULL,
    FOREIGN KEY (preferred_city_id) REFERENCES cities(id) ON DELETE SET NULL,
    FOREIGN KEY (preferred_cast_id) REFERENCES user_cast(id) ON DELETE SET NULL
);
-- personality profile
CREATE TABLE personality_profile (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    profile_id INT NOT NULL,
    favorite_movie VARCHAR(256) DEFAULT NULL,
    favorite_book VARCHAR(256) DEFAULT NULL,
    sort_of_music VARCHAR(256) DEFAULT NULL,
    hobbies VARCHAR(256) DEFAULT NULL,
    dress_sense VARCHAR(256) DEFAULT NULL,
    sense_of_humor VARCHAR(256) DEFAULT NULL,
    describe_personality VARCHAR(256) DEFAULT NULL,
    like_to_travel VARCHAR(256) DEFAULT NULL,
    partner_diff_culture VARCHAR(256) DEFAULT NULL,
    spend_weekend VARCHAR(256) DEFAULT NULL,
    perfect_match VARCHAR(256) DEFAULT NULL,
    is_complete BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_by INT,
    updated_by INT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (profile_id) REFERENCES profiles(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
);