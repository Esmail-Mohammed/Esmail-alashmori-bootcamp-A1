
#include <stdio.h>

int main(int argc, char *argv[])
{
    FILE *myfile;
    unsigned char buffer[16];
    size_t bytesRead;
    int i;

    // Check if the user entered a file name

    if (argc != 2)
    {
        printf("Usage: %s <filename>\n", argv[0]);
        return 1;
    }

    // Open the file in binary reading mode

    myfile = fopen(argv[1], "rb");

    if (myfile == NULL)
    {
        printf("--- Cannot open the file! ---\n");
        return 1;
    }

    printf("\nHexadecimal Viewer\n");
    printf("^---------------_----------------^\n");

    // Read 16 bytes each time

    while ((bytesRead = fread(buffer, 1, 16, myfile)) > 0)
    {
        // Print hexadecimal values

        for (i = 0; i < bytesRead; i++)
        {
            printf("%02X ", buffer[i]);
        }

        // Add spaces if the last line has less than 16 bytes

        for (i = bytesRead; i < 16; i++)
        {
            printf("   ");
        }

        printf(" | ");

        // Print ASCII characters
        
        for (i = 0; i < bytesRead; i++)
        {
            if (buffer[i] >= 32 && buffer[i] <= 126)
                printf("%c", buffer[i]);
            else
                printf(".");
        }

        printf("\n");
    }
   
    fclose(myfile);

    printf("^--------------_-----------------^\n");
    printf("File reading completed.\n");

    return 0;
}
