##Projeto Padrao

###TODOS


###Dados
- URL HOMOLOGAÇÂO: (TODO) Subir projeto para homologação
- URL PRODUÇÂO: (TODO) Subir projeto para produção

###MetaDados
Toda url de requisição deverá ter a url base.  
Neste documento haverá algumas variaveis e tais devem ser substituidas:  
- {{url}} -> Url que será usada  
- {{token}} -> Token do JWT (explicado no metodo Login)  

Para autenticação foi utilizado JWT, onde ao fazer login um token é retornado e esse token precisa ser passado via header Authorization do tipo Bearer  
Exemplo: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNTE2Mjc5MTcyLCJleHAiOjE1MTYyODI3NzIsIm5iZiI6MTUxNjI3OTE3MiwianRpIjoib2h0a0VxVUtIdkkzakxMdSIsInN1YiI6MSwicHJ2IjoiZjkzMDdlYjVmMjljNzJhOTBkYmFhZWYwZTI2ZjAyNjJlZGU4NmY1NSJ9.cOjyx6-x3_KHwGgfSh9bSX0g90hNOcyFGB4sMBoMRCI  

Cada token gerado se expira em 6 horas, logo quando ele for expirado, um parametro new_token no header do response será retornado, substituindo o token antigo.
Para isso, cada response deverá ser interceptado para a verificação da existencia do header new_token.

Caso o token for expirado e não for renovado, um erro com o codigo 401 irá retornar com o header WWW-Authenticate com o valor jwt-auth, isso significa que o token expirou e não pode ser renovado

Toda requisição está sujeita a voltar um erro, para lidar com o erro, pode-se verificar o codigo HTTP do response
Segue o exemplo de uma requisição com um erro
Response:
````json
{
    "message": "Mensagem do erro",
    "success": false
}
````

###Arquivos
Métodos para inserção de arquivos e remoção dos mesmos.
Esses métodos não precisam de token

O fluxo de arquivo funciona da seguinte forma: na inserção da foto ou arquivo, deve-se mandar uma request para /api/uploadTmp, onde esse método retornará o nome do arquivo e se conseguiu incluir, segue exemplo:<br>
**Método não é em json e sim em form-data**
- Method: POST
- Tipo: form-data
- EndPoint: /api/uploadTmp
- Request:
    file: Input do tipo arquivo
    extension: string do com a extensão do arquivo ( opcional )
- Response:
````json
{
    "success": true,
    "message": "Arquivo salvo com sucesso",
    "data": "nome_do_arquivo.extensao_do_arquivo"
}
````
Após a inserção do arquivo, caso o usuário deseje remover o arquivo, deve-se mandar uma request para /api/removeTmp/nome_do_arquivo.extensao_do_arquivo, onde esse método retornará se foi removido com sucesso, segue o exemplo da request:<br>
- Method: POST
- EndPoint: /api/removeTmp/{nome.extensao}
- Response:
````json
{
    "success": true,
    "message": "Arquivo removido com sucesso",
    "data": "nome_do_arquivo.extensao_do_arquivo"
}
````

Após essa parte concluida, guarda-se o nome do arquivo, passando na request da entidade correspondente.

###Exemplos de Documentação

####Exemplo com request e response

- Method: POST
- EndPoint: /api/usuario
- Headers: "Authorization: Bearer {{token}}"|"Accept: application/json"
- Request: 
````json
{
	"key": "value"
}
````
- Response:
````json
{
    "data": {
        "key": "value"
    },
    "success": true
}
````
