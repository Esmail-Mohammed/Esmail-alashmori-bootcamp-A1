
#include <stdio.h>
#include <string.h>

int main(int argc, char *argv[])
{

    FILE *myfile;
    char line[512];
    char *keyword;
    int lineNumber = 0;
    int alertCount = 0;

    // Check the entered arguments

    if (argc != 3)
    {
        printf("Usage: %s <filename> <keyword>\n", argv[0]);
        return 1;
    }

    keyword = argv[2];

    // Open the  file

    myfile = fopen(argv[1], "r");

    if (myfile == NULL)
    {

        printf(" Cannot open the file!\n");
        return 1;
    }

    printf("\nLog File Analyzer\n");
    printf("^-------------_------------------^\n");
    printf("Searching for: %s\n\n", keyword);

    // Read the file line by line

    while (fgets(line, sizeof(line), myfile) != NULL)
    {
        lineNumber++;

        // Search for the keyword

        if (strstr(line, keyword) != NULL)
        {
            alertCount++;

            printf("Alert #%d\n", alertCount);
            printf("Line Number: %d\n", lineNumber);
            printf("Log: %s", line);

            // Add a new line if needed

            if (line[strlen(line) - 1] != '\n')
                printf("\n");

            printf("^--------------_-----------------^\n");
        }
    }

    // Display the final report

    printf("\nAnalysis Report\n");
    printf("^---------------_----------------^\n");
    printf("Total Alerts Found: %d\n", alertCount);

    fclose(myfile);

    return 0;
}
