-- Active: 1764673028424@@127.0.0.1@3306@smart-wallet
create table incomes(
    id INT AUTO_INCREMENT PRIMARY KEY,
    amount DECIMAL(10,2) NOT NULL,
    description VARCHAR(255),
    date DATE NULL
);
create table expenses(
    id INT AUTO_INCREMENT PRIMARY KEY,
    amount DECIMAL(10,2) NOT NULL,
    description VARCHAR(255) not NULL,
    date DATE NOT NULL
);
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
ALTER TABLE incomes ADD user_id INT NOT NULL;
ALTER TABLE expenses ADD user_id INT NOT NULL;

CREATE TABLE cards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    provider VARCHAR(100) NOT NULL,
    card_last4 VARCHAR(4) NOT NULL,
    limit_amount DECIMAL(10,2) NOT NULL DEFAULT 0,
    expiry_date DATE NOT NULL,
    is_main TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_cards_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);



ALTER TABLE incomes ADD card_id INT NOT NULL;
ALTER TABLE expenses ADD card_id INT NOT NULL;

CREATE TABLE transfer (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    sender_card_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_sender
        FOREIGN KEY (sender_id) REFERENCES users(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_receiver
        FOREIGN KEY (receiver_id) REFERENCES users(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_sender_card
        FOREIGN KEY (sender_card_id) REFERENCES cards(id)
        ON DELETE CASCADE
);
