


#include <stdio.h>
#include <stdbool.h>
#include <ctype.h>
#include <string.h>

void check_password(const char *password){
    int length = strlen(password);
    int has_upper = 0;
    int has_lower = 0;
    int has_digit = 0;
    int has_special = 0;
    int is_length_ok = 0;

    for(int c = 0; c < length; c++){
        if(isupper(password[c])) has_upper = 1;
        else if(islower(password[c])) has_lower = 1;
        else if(isdigit(password[c])) has_digit = 1;
        else has_special = 1;
    }

    if(length >= 10) is_length_ok = 1;

    int score = has_upper + has_lower + has_digit + has_special + is_length_ok;

    if(!is_length_ok){
        printf("Your Password is Weak");
    } else if (score >= 4){
        printf("Your Password is Strong");
    } else {
        printf("Your Password is Medium");
    }

}

int main(){
    char password[50];
    

    printf("Type a Password to check\n");
    if(scanf("%49s", password) == 1){
        check_password(password);
    }

    return 0;
}