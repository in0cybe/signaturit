# this Solution is developed in CodeIgniter 4 Framework

## Requirements of the solution

First Case
    We want you to automate this process, given a contract with your 2 parties involved and their signatures, and indicate which one wins the test. Make a program that receives both contracts as input (for example KN vs NNV ) and gives the winner as output. We should be able to interact from console or HTTP.

Second Case
    Sometimes the contract does not have all the signs, so we represent it using the #character. Taking into account that only one signature per part
    can be empty to be valid, determine which is the minimum signature necessary to win the trial given a contract with the signatures of the known
    opposition party.
    For example, given N#V vs NVV should return N.
    Make a program that receives both contracts as input (for example N#V vs NVV ) and gives the signature required to win as output. We should
    be able to interact from console or HTTP.


## Server Requirements

Create a VirtualHost to the public solutions document(signaturit/public).

Example confinguration in xampp (httpd.conf):

    DocumentRoot "C:/signaturit/public"
    <Directory "C:/signaturit/public">