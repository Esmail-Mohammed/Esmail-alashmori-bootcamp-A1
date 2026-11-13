
import socket

# Function to grab service banner


def grab_banner(target_ip, port):
    try:
        with socket.create_connection((target_ip, port), timeout=3) as my_socket:

            my_socket.settimeout(3)

            # Send HTTP request for web services
            
            
            if port in [80, 8080]:
                request = f"HEAD / HTTP/1.1\r\nHost: {target_ip}\r\nConnection: close\r\n\r\n"
                my_socket.sendall(request.encode())

            # Receive banner data
            
            banner = my_socket.recv(1024).decode("utf-8", errors="ignore")

            if banner:
                first_line = banner.splitlines()[0]
                print(f"[+] Port {port}: {first_line}")
            else:
                print(f"[-] Port {port}: No banner received")

    except socket.timeout:
        print(f"[-] Port {port}: Connection timed out")

    except OSError:
        print(f"[-] Port {port}: Connection failed")


# Get target IP

target_ip = input("Enter Target IP: ")

# Common service ports

ports = [21, 22, 25, 80, 110, 143, 8080]

print("\nBanner Grabbing Tool")
print("-" * 40)

# Scan each port

for port in ports:
    grab_banner(target_ip, port)

print("-" * 40)
print("Scanning Completed!")
