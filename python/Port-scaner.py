
import socket
import time
from concurrent.futures import ThreadPoolExecutor, as_completed


# Function to scan one port

def scan_port(target_ip, port):
    try:
        with socket.socket(socket.AF_INET, socket.SOCK_STREAM) as my_socket:
            my_socket.settimeout(0.5)

            result = my_socket.connect_ex((target_ip, port))

            if result == 0:
                return port

    except OSError:
        pass

    return None


# Get target IP from the user

target_ip = input("Enter Target IP: ")

try:
    target_ip = socket.gethostbyname(target_ip)
except socket.gaierror:
    print(" Invalid IP address!")
    exit()

print("\nStarting Port Scanner...")
print("Target:", target_ip)
print("-" * 35)

start_time = time.perf_counter()
open_ports = []

# Scan ports using multiple threads

with ThreadPoolExecutor(max_workers=50) as executor:

    tasks = [
        executor.submit(scan_port, target_ip, port)
        for port in range(1, 1025)
    ]

    for task in as_completed(tasks):
        port = task.result()

        if port is not None:
            open_ports.append(port)
            print(f"[OPEN] Port {port}")

# Calculate scanning time

end_time = time.perf_counter()

print("-" * 35)
print("Scan Completed!")
print("Open Ports:", len(open_ports))
print("Time Taken:", round(end_time - start_time, 2), "seconds")
