#include <stdio.h>
#include <stdbool.h>
#include <ctype.h>
#include <string.h>

void check_password(const char *password){
    int length = strlen(password);
    int upper = 0;
    int lower = 0;
    int digit = 0;
    int special = 0;
    int length_ok = 0;

    for(int c = 0; c < length; c++){
        if(isupper(password[c])) upper = 1;
        else if(islower(password[c])) lower = 1;
        else if(isdigit(password[c])) digit = 1;
        else special = 1;
    }

    if(length >= 10) length_ok = 1;

    int score = upper + lower + digit + special + length_ok;

    if(!length_ok){
        printf("Your Password is Week");
    } else if (score >= 4){
        printf("Your Password is Strong");
    } else {
        printf("Your Password is Med");
    }
}

int main(){
    char password[40];
    

    printf(" Password to check\n");
    if(scanf("%39s", password) == 1){
        check_password(password);
    }
    return 0;
}