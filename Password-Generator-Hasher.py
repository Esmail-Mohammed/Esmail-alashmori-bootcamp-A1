
import secrets
import string
import hashlib


# Function to generate a secure password

def generate_password(length):
    chars = string.ascii_letters + string.digits + string.punctuation

    password = [
        secrets.choice(string.ascii_uppercase),
        secrets.choice(string.ascii_lowercase),
        secrets.choice(string.digits),
        secrets.choice(string.punctuation)
    ]

    for i in range(length - 4):
        password.append(secrets.choice(chars))

    secrets.SystemRandom().shuffle(password)

    return ''.join(password)


# Function to calculate SHA-256 hash

def calculate_hash(text):
    hash_value = hashlib.sha256(text.encode()).hexdigest()
    return hash_value


# Get password length

try:
    password_length = int(input("Enter Password Length: "))

    if password_length < 4:
        print("Error: Password length must be at least 4!")

    else:
        my_password = generate_password(password_length)
        password_hash = calculate_hash(my_password)

        print("\nPassword Generator & SHA-256 Hasher")
        print("-" * 45)

        print("Generated Password:", my_password)
        print("SHA-256 Hash:", password_hash)

        print("-" * 45)
        print("Operation Completed Successfully!")

except ValueError:
    print("Error: Please enter a valid number!")
