
import hashlib
import time

# Function to calculate SHA-256 hash

def calculate_hash(filename):
    sha256 = hashlib.sha256()

    with open(filename, "rb") as myfile:
        while True:
            data = myfile.read(4096)

            if not data:
                break

            sha256.update(data)

    return sha256.hexdigest()


# Get file name from user

filename = input("Enter file name to monitor: ")

try:
    # Create the baseline hash
    
    baseline_hash = calculate_hash(filename)

    print("\nFile Integrity Monitoring Started")
    print("Monitoring file:", filename)
    print("Baseline Hash:", baseline_hash)
    print("-" * 50)

    # Start monitoring
    
    while True:
        time.sleep(3)

        current_hash = calculate_hash(filename)

        if current_hash != baseline_hash:
            print("\n[CRITICAL ALERT] File has been modified!")
            print("Old Hash:", baseline_hash)
            print("New Hash:", current_hash)
            break

        else:
            print("[OK] File integrity is safe.")

except FileNotFoundError:
    print("Error: File not found!")

except PermissionError:
    print("Error: Permission denied!")

except KeyboardInterrupt:
    print("\nMonitoring stopped by user.")

