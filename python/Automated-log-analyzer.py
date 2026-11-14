
import re

# Define attack patterns

patterns = {
    "SQL Injection": re.compile(r"UNION\s+SELECT|OR\s+1=1", re.IGNORECASE),
    "Path Traversal": re.compile(r"\.\./|%2e%2e%2f|/etc/passwd", re.IGNORECASE)
}

# Store detected attacks

attack_count = {
    "SQL Injection": 0,
    "Path Traversal": 0
}

total_attacks = 0

# Get log file name

filename = input("Enter Log File Name: ")

try:
    with open(filename, "r", encoding="utf-8", errors="ignore") as myfile:

        print("\nAutomated Log Analyzer")
        print("-" * 45)

        # Read logs line by line
        
        for line_number, line in enumerate(myfile, start=1):

            # Get attacker IP
            
            ip_match = re.search(r"\b(?:\d{1,3}\.){3}\d{1,3}\b", line)
            attacker_ip = ip_match.group() if ip_match else "Unknown"

            # Check each attack pattern
            
            for attack_type, pattern in patterns.items():

                if pattern.search(line):
                    total_attacks += 1
                    attack_count[attack_type] += 1

                    print(f"[ALERT] {attack_type}")
                    print(f"IP Address: {attacker_ip}")
                    print(f"Line Number: {line_number}")
                    print("-" * 45)

        # Display final report
        
        print("\nSecurity Analysis Report")
        print("-" * 45)
        print("Total Attacks:", total_attacks)

        for attack_type, count in attack_count.items():
            print(f"{attack_type}: {count}")

except FileNotFoundError:
    print("Error: Log file not found!")

except OSError:
    print("Error: Cannot read the log file!")
