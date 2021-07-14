curl --header "Content-Type: application/json" \
  --request POST \
  --data '{"name":"example","description":"An example", "definition": "some definition", "owner": "rpopuc"}' \
  http://register.local/api/v1/providers