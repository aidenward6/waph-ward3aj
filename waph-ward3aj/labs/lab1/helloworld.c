#include <stdio.h>

int main(void) {
  // CGI header
  printf("Content-Type: text/html; charset=utf-8\n\n");
  
  // HTML Template
  printf("<!DOCTYPE html><html>");
  printf("<head><title>WAPH Lab 1 - Aiden Ward</title></head>");
  printf("<body>");
  
  // Required Header and Paragraphs
  printf("<h1>Web Application Programming and Hacking</h1>");
  printf("<p>Student: Aiden Ward</p>");
  printf("<p>Course: WAPH - Spring 2026</p>");
  
  printf("</body></html>\n");
  
  return 0;
}
