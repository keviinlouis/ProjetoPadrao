##Projeto PetLovers

###TODOS
- Fazer sistema de pagamento
- Fazer WS atualidades e duvidas na tela de termos de uso

###Dados
- URL HOMOLOGAÇÂO: hom-petlovers.devmakerdigital.com.br
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

###Helpers ou Utils
Métodos para listagem de dados como raças, familias e etc.

####Listagem de Categorias
- Method: GET
- EndPoint: /api/categorias
- Headers: "Accept: application/json"
- Response:
````json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "nome": "Mercado"
        },
        {
            "id": 2,
            "nome": "Match"
        },
        {
            "id": 3,
            "nome": "Doação"
        },
        {
            "id": 4,
            "nome": "Perdido"
        },
        {
            "id": 5,
            "nome": "Pessoal"
        }
    ]
}
````

####Listagem de familias
Este método pode ser passado com a query string de raça, ficando "/api/familias?raca", para trazer as raças de cada familia
- Method: GET
- EndPoint: /api/familias
- Headers: "Accept: application/json"
- Response:
````json
{
    "data": [
        {
            "id": 1,
            "nome": "Cachorros"
        },
        {
            "id": 2,
            "nome": "Gatos"
        },
        {
            "id": 3,
            "nome": "Aves"
        },
        {
            "id": 4,
            "nome": "Outros"
        }
    ],
    "success": true
}
````

####Listagem de Raças por Familia
Este método pode ser passado com a query string de familias, ficando "/api/racas/{id}?raca", para trazer as familias de cada raca
- Method: GET
- EndPoint: /api/racas/{familia_id}
- Headers: "Accept: application/json"
- Response:
````json
{
    "data": [
        {
            "id": 5,
            "nome": "Siamês"
        },
        {
            "id": 6,
            "nome": "Pelo-Curto"
        },
        {
            "id": 7,
            "nome": "Persa"
        },
        {
            "id": 8,
            "nome": "Vira-Lata"
        }
    ],
    "success": true
}
````

####Listagem de Cores
- Method: GET
- EndPoint: /api/cores
- Headers: "Accept: application/json"
- Response:
````json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "nome": "Creme"
        },
        {
            "id": 2,
            "nome": "Marrom"
        },
        {
            "id": 3,
            "nome": "Braco"
        },
        {
            "id": 4,
            "nome": "Preto"
        },
        {
            "id": 5,
            "nome": "Cinza"
        }
    ]
}
````

####Listagem de Banners
Para este método há alguns tipos de banner para determinadas páginas.
**MEUS ANUNCIOS** = 1;
**MEUS PETS** = 2;
**ATUALIDADES** = 3;

- Method: GET
- EndPoint: /api/banners/{tipo de banner}
- Headers: "Accept: application/json"
- Response:
````json
{
    "success": true,
    "data": "http://url_para_o_banner"
}
````

###Autenticações
Os métodos de autenticações se consistem em 5
- Cadastro 
- Cadastro com facebook
- Login
- Login com facebook
- Redefinir senha
Desses 5, os de cadastro e login retornam o parametro token que deve ser usado no header das requisições que precisam de token

####Cadastro de Dono
Para cadastro há algumas considerações <br>
Campo Genero aceita apenas dois valores, sendo eles **M** para masculino e **F** para feminino<br>
Campo senha e senha confirmation deverão ser passados caso não haja o campo facebook_id e facebook_id deverá ser passado caso não haja o campo senha e senha_confirmation<br>
Campo senha deverá ter no minimo 6 caracteres<br>
Campo path_perfil deverá seguir o padrão de upload de arquivos<br>
Campo telefone deverá seguir o padrão com mascara e sem espaços, podendo ter o padrão telefone fixo ou telefone celular<br>

- Method: POST
- EndPoint: /api/cadastro
- Request: 
````json
{
	"nome": "Nome Teste",
	"genero": "M",
	"data_nascimento": "01/01/2000",
	"estado": "PR",
	"cidade": "Curitiba",
	"telefone": "(99)99999-9999",
	"email": "teste@mail.com",
	"senha": "123456",
	"senha_confirmation": "123456",
	"como_soube": "Google",
	"path_perfil": "nome_do_arquivo.extensao_do_arquivo",
	"device_token": "asdfasdf4as6d84fas5d",
    "device_model": "android ou ios"
}
````
- Response:
````json
{
    "data": {
        "id": 5,
        "nome": "Nome Teste",
        "email": "teste@mail.com",
        "telefone": "(99)99999-9999",
        "estado": "PR",
        "cidade": "Curitiba",
        "url_foto_perfil": "http://localhost:8000/storage/donos/5/fotos_perfil/nome_do_arquivo.extensao_do_arquivo",
        "data_nascimento": "01/01/2000",
        "device_token": null,
        "device_model": null
    },
    "success": true,
    "token": "{{token}}"
}
````

####Login do dono
O login pode ser feito de duas maneiras, via email e senha (Request 1) ou facebook ID (Request 2)
- Method: POST
- EndPoint: /api/login
- Request 1: 
````json
{
	"email":"teste@mail.com",
	"senha": "123456"
}
````
- Request 2: 
````json
{
	"facebook_id": "1234568978469186864684"
}
````
- Response:
````json
{
    "data": {
        "id": 5,
        "nome": "Nome Teste",
        "email": "teste@mail.com",
        "telefone": "(99)99999-9999",
        "estado": "PR",
        "cidade": "Curitiba",
        "url_foto_perfil": "http://localhost:8000/storage/donos/5/fotos_perfil/nome_do_arquivo.extensao_do_arquivo",
        "data_nascimento": "01/01/2000",
        "device_token": "asdfasdf4as6d84fas5d",
        "device_model": "android ou ios"
    },
    "success": true,
    "token": "{{token}}"
}
````

####Esqueci a senha
Para o metodo esqueci a senha, será enviado um email para o usuario solicitado com um link e um token, ao acessar o link, ele podera escolher outra senha

- Method: POST
- EndPoint: /api/redefinir-senha
- Request: 
````json
{
    "email":"teste@mail.com"
}
````
- Response:
````json
{
    "success": true,
    "message": "Email enviado com sucesso para teste@mail.com"
}
````

###Dono
Métodos para o dono

####Ver próprio perfil
- Method: GET
- EndPoint: /api/me
- Headers: "Authorization: Bearer {{token}}"|"Accept: application/json"
- Response:
````json
{
    "data": {
        "id": 4,
        "nome": "Nome Teste",
        "email": "teste@mail.com",
        "telefone": "(99)99999-9999",
        "estado": "PR",
        "cidade": "Curitiba",
        "url_foto_perfil": "http://localhost:8000/storage/donos/4/fotos_perfil/5a9ef9abe2986.jpg",
        "data_nascimento": "01/01/2000",
        "device_token": "asdfasdf4as6d84fas5d",
        "device_model": "android ou ios"
    },
    "success": true
}
````

####Editar Perfil
Este método edita o perfil do usuario, sendo assim, nenhum campo é obrigatório, porém alguns campos são necessários se outros existirem.
As mesmas regras do cadastro de usuario são aplicadas aqui, menos a obrigatoriedade
Campo senha precisa do campo nova_senha
Campo nova_senha precisa do campo senha e do campo nova_senha_confirmation
- Method: PUT
- EndPoint: /api/me
- Headers: "Authorization: Bearer {{token}}"|"Accept: application/json"
- Request: 
````json
{
  "nome": "Nome Teste",
  "genero": "M",
  "data_nascimento": "01/01/2000",
  "estado": "PR",
  "cidade": "Curitiba",
  "telefone": "(99)99999-9999",
  "email": "teste2@mail.com",
  "senha": "1234567",
  "nova_senha": "1234567",
  "nova_senha_confirmation": "1234567",
  "como_soube": "Google",
  "device_token": "asdfasdf4as6d84fas5d",
  "device_model": "android ou ios",
  "path_perfil": "5aa03c5c0528b.jpg"
}
````

####Deletar Perfil
Este método deleta o perfil do usuario, este perfil é recuperavel //TODO Verificar recuperação de conta
- Method: DELETE
- EndPoint: /api/me
- Headers: "Authorization: Bearer {{token}}"|"Accept: application/json"
- Response:
````json
{
    "data": {
        "id": 4,
        "nome": "Nome Teste",
        "email": "teste@mail.com",
        "telefone": "(99)99999-9999",
        "estado": "PR",
        "cidade": "Curitiba",
        "url_foto_perfil": "http://localhost:8000/storage/donos/4/fotos_perfil/5a9ef9abe2986.jpg",
        "data_nascimento": "01/01/2000",
        "device_token": null,
        "device_model": null
    },
    "success": true
}
````

####Ver perfil de um dono
- Method: GET
- EndPoint: /api/dono/{id}
- Headers: "Authorization: Bearer {{token}}"|"Accept: application/json"
- Response:
````json
{
    "data": {
        "id": 4,
        "nome": "Nome Teste",
        "email": "teste@mail.com",
        "telefone": "(99)99999-9999",
        "estado": "PR",
        "cidade": "Curitiba",
        "url_foto_perfil": "http://localhost:8000/storage/donos/4/fotos_perfil/5a9ef9abe2986.jpg",
        "data_nascimento": "01/01/2000",
        "device_token": null,
        "device_model": null,
        "animais": [
            {
                "id": 1,
                "nome": "Animal Teste",
                "cor": "Marrom",
                "idade": "79 anos e 7 meses",
                "porte_label": "Grande",
                "genero_label": "Feminino",
                "fotos": [
                    "http://localhost/storage/donos/4/animais/2/fotos/5aa30cb9753fa.jpg",
                    "http://localhost/storage/donos/4/animais/2/fotos/5aa30cb9b6af2.jpg",
                    "http://localhost/storage/donos/4/animais/2/fotos/5aa30cb9b9f23.jpg"
                ],          
                "raca": {
                    "id": 7,
                    "nome": "Persa"
                },
                "familia": {
                    "id": 2,
                    "nome": "Gatos"
                },
                "categoria": {
                    "id": 4,
                    "nome": "Perdido"
                }
            }
        ]
    },
    "success": true
}
````

####Listagem de animais do perfil por categoria
Este método lista os animais do dono por categoria
O campo categoria aceita os ids existentes em categorias de animal

- Method: GET
- EndPoint: /api/me/animais?categoria={animais_categoria_id}
- Headers: "Authorization: Bearer {{token}}"|"Accept: application/json"
- Response:
````json
{
    "data": [
        {
            "id": 50,
            "nome": "Teste Animal 1",
            "cor": "Marrom",
            "porte_label": "Grande",
            "url_primeira_foto": "http://localhost:8000/storage/donos/1/animais/50/fotos/5aa6a755a5c97.jpg",
            "raca": {
                "id": 1,
                "nome": "Labrador"
            },
            "dono": {
                "id": 1,
                "nome": "Dr. Emília Juliana Saraiva"
            }
        },
        {
            "id": 51,
            "nome": "Teste Animal 1",
            "cor": "Marrom",
            "porte_label": "Grande",
            "url_primeira_foto": "http://localhost:8000/storage/donos/1/animais/51/fotos/5aa6a755ab728.jpg",
            "raca": {
                "id": 1,
                "nome": "Labrador"
            },
            "dono": {
                "id": 1,
                "nome": "Dr. Emília Juliana Saraiva"
            }
        }
    ],
    "success": true
}
````

####Listagem de favoritos
Este método lista os animais favoritados pelo dono logado

- Method: GET
- EndPoint: /api/me/favoritos
- Headers: "Authorization: Bearer {{token}}"|"Accept: application/json"
- Response:
````json
{
    "data": [
        {
            "id": 4,
            "nome": "Cristóvão Sérgio Serna",
            "cor": "u1Vrqwp7I",
            "porte_label": "Médio",
            "url_primeira_foto": "http://localhost/storage/donos/5/animais/4/fotos/5aa30cb96d48f.jpg",
            "raca": {
                "id": 3,
                "nome": "Poodle"
            },
            "dono": {
                "id": 5,
                "nome": "Carla Brito Fontes"
            }
        },
        {
            "id": 5,
            "nome": "Sr. Ricardo Delvalle Montenegro",
            "cor": "yYFY1u2JxN",
            "porte_label": "Grande",
            "url_primeira_foto": "http://localhost/storage/donos/5/animais/5/fotos/5aa30cb9a652c.jpg",
            "raca": {
                "id": 13,
                "nome": "Tartaruga"
            },
            "dono": {
                "id": 5,
                "nome": "Carla Brito Fontes"
            }
        },
        {
            "id": 6,
            "nome": "Dr. Irene Dominato Serrano",
            "cor": "G1EQrsae0H",
            "porte_label": "Médio",
            "url_primeira_foto": "http://localhost/storage/donos/5/animais/6/fotos/5aa6a755719d3.jpg",
            "raca": {
                "id": 10,
                "nome": "Papagaio"
            },
            "dono": {
                "id": 5,
                "nome": "Carla Brito Fontes"
            }
        }
    ],
    "success": true
}
````

####Listagem de matchs
Este método lista os animais com matchs pelo dono logado

- Method: GET
- EndPoint: /api/me/matchs
- Headers: "Authorization: Bearer {{token}}"|"Accept: application/json"
- Response:
````json
{
    "data": [
        {
            "id": 52,
            "nome": "Teste Animal 1",
            "cor": "Marrom",
            "porte_label": "Grande",
            "url_primeira_foto": "http://localhost:8000/storage/donos/1/animais/52/fotos/5aa6a7548d85c.jpg",
            "raca": {
                "id": 1,
                "nome": "Labrador"
            },
            "dono": {
                "id": 1,
                "nome": "Dr. Emília Juliana Saraiva"
            }
        },
        {
            "id": 53,
            "nome": "Teste Animal 1",
            "cor": "Marrom",
            "porte_label": "Grande",
            "url_primeira_foto": "http://localhost:8000/storage/donos/1/animais/53/fotos/5aa6a7556e540.jpg",
            "raca": {
                "id": 1,
                "nome": "Labrador"
            },
            "dono": {
                "id": 1,
                "nome": "Dr. Emília Juliana Saraiva"
            }
        }
    ],
    "success": true
}
````

###Animais
Métodos para gerenciamento de animais<br>
Tipos de animais:<br>
- **MERCADO** = 1
- **MATCH** = 2
- **DOACAO** = 3
- **PERDIDO** = 4
- **PESSOAL** = 5

####Cadastro Animal
Para o cadastro de animal, deve-se atentar ao tipo do animal<br>
Tipo **MERCADO**: Necessita do parametro preço (preco)<br>
Tipo **MATCH**: Não necessita de nenhum campo adicional<br>
Tipo **DOACAO**: Não necessita de nenhum campo adicional<br>
Tipo **PERDIDO**: Necessita de um campo do tipo DATE com a data do desaparecimento (data_desaparecimento)<br>
Tipo **PESSOAL**: Não necessita de nenhum campo adicional<br>
O campo fotos é obrigatorio e o campo videos é opcional<br>
O campo raca_id é vinda da request **####Listagem de Raças por Familia**<br>
O campo porte aceita apenas 3 conteudos: [P para pequeno, M para médio, G para grande]<br>
O campo genero aceita apenas 2 conteudos: [M para masculino, F para feminino]<br>
o campo animal_categoria_id é vinda da request **####Lista Categorias Animais**<br>
(TODO) Verificar idade e cor<br>

- Method: POST
- EndPoint: /api/animal
- Headers: "Authorization: Bearer {{token}}"|"Accept: application/json"
- Request: 
````json
{
	"nome": "Teste Animal 1",
	"raca_id": 1,
	"cor": "Marrom",
    "idade_mes": 6,
    "idade_ano": 0,
	"porte": "G",
	"genero": "M",
	"estado": "PR",
	"cidade": "Curitiba",
	"animal_categoria_id": 1,
	"fotos":[
		"nome_arquivo.extensao_arquivo",
		"5a9da93861044.jpg"
	],
	"preco": 105.50,
    "data_desaparecimento": "01/01/2000"
   
}
````
- Response:
````json
{
    "data": {
        "id": 2,
        "nome": "Teste Animal 1",
        "cor": "Marrom",
        "idade": 12,
        "porte": "G",
        "porte_label": "Grande",
        "genero": "M",
        "genero_label": "Masculino",
        "estado": "PR",
        "cidade": "Curitiba",
        "informacoes": null,
        "preco": 105.5,
        "data_desaparecimento": null,
        "peso": null,
        "fotos": [
            "http://localhost:8000/storage/donos/4/animais/2/fotos/5a9ef9abe2986.jpg"
        ],
        "raca": {
            "id": 1,
            "nome": "Labrador"
        },
        "familia": {
            "id": 1,
            "nome": "Cachorros"
        },
        "categoria": {
            "id": 1,
            "nome": "Mercado"
        },
        "dono": {
            "id": 4,
            "nome": "Nome Teste",
            "email": "teste@mail.com",
            "telefone": "(99)99999-9999",
            "estado": "PR",
            "cidade": "Curitiba",
            "url_foto_perfil": "http://localhost:8000/storage/donos/4/fotos_perfil/5a9ef9abe2986.jpg",
            "data_nascimento": "01/01/2000",
            "device_token": null,
            "device_model": null
        }
    },
    "success": true
}
````

####Listagem Animais
Este método lista os animais de acordo com os filtros
Os campos latitude e longitude são requeridos quando o campo raio existe
Os campos que possuem "min" devem ser menor que os campos "max" correspondentes, e vice versa
O campo porte aceita apenas 3 conteudos: [P para pequeno, M para médio, G para grande]<br>
O campo genero aceita apenas 2 conteudos: [M para masculino, F para feminino]<br>


- Method: POST
- EndPoint: /api/animais
- Headers: "Authorization: Bearer {{token}}"|"Accept: application/json"
- Request: 
````json
{
    "latitude": -25.472694,
    "longitude": -49.242485,
    "raio": 70,
    "preco_min": 10.51,
    "preco_max": 50,
    "estado": "PR",
    "familia_id": 1,
    "raca_id": 1,
    "categoria": 1,
    "porte": "M",
    "genero": "F",
    "idade_ano_min": 0,
    "idade_ano_max": 200,
    "idade_mes_min": 0,
    "idade_mes_max": 11
}
````
- Response:
````json
{
    "data": {
        "id": 52,
        "texto": "insira a mensagem aqui",
        "destinatario": {
            "id": 4,
            "nome": "Jasmin Zaragoça Delatorre Jr."
        },
        "remetente": {
            "id": 1,
            "nome": "Dr. Mia Furtado Montenegro"
        },
        "data": "12/03/2018",
        "hora": "12:43:04",
        "data_hora_label": "há 1 segundo",
        "aberto": 0
    },
    "success": true
}
````

####Favoritar um animal
Este método favorita ou desfavorita um animal, caso ele não estiver favoritado, favorita, se ele ja estiver favoritado, desfavorita.
O campo data no retorno identifica a ação ocorrida, sendo 0 para desfavoritado e 1 para favoritado;
- Method: POST
- EndPoint: /api/animal/{animal id}/favoritar
- Headers: "Authorization: Bearer {{token}}"|"Accept: application/json"
- Response:
````json
{
    "success": true,
    "message": "Favoritado",
    "data": 1
}
````

####Curtir um animal
Este método curte ou descurte um animal, caso ele não estiver curtido, curte, se ele ja estiver curtido, descurte.
Caso o dono desde animal tiver curtido algum animal do usuario logado, da um **Match**
O campo data no retorno identifica a ação ocorrida, sendo **0** para descurtido, **1** para curtido e **2** para Match;
- Method: POST
- EndPoint: /api/animal/{animal id}/curtir
- Headers: "Authorization: Bearer {{token}}"|"Accept: application/json"
- Response:
````json
{
    "success": true,
    "message": "Animal Curtido",
    "data": 2
}
````

###Historicos

####Lista historicos do animal
Este método é para ver um historico
Para ver o historico, o animal do historico precisa pertencer ao usuario logado
TODO Ver como ficará a response para montar o grafico
- Method: GET
- EndPoint: /api/animal/{animal_id}/historicos
- Headers: "Authorization: Bearer {{token}}"|"Accept: application/json"
- Response:
````json
{
    "data": [
        {
            "id": 4,
            "peso": 50.25,
            "altura": 120,
            "data": "14/03/2018"
        },
        {
            "id": 5,
            "peso": 50.25,
            "altura": 120,
            "data": "14/03/2018"
        }
    ],
    "success": true,
    "length": 2
}
````

####Criar historico para o animal
Este método cria um historico para o animal do tipo pessoal
O animal em questão precisa ser do tipo pessoal
O animal em questão precisa pertencer ao usuario logado

- Method: POST
- EndPoint: /api/animal/{animal_id}/historico
- Headers: "Authorization: Bearer {{token}}"|"Accept: application/json"
- Request:
````json
{
	"peso": 50.25,
	"altura": 120,
	"data": "14/03/2018"
}
````
- Response:
````json
{
    "data": {
        "id": 10,
        "peso": 50.25,
        "altura": 120,
        "data": "14/03/2018"
    },
    "success": true
}
````

####Ver historico para o animal
Este método é para ver um historico
Para ver o historico, o animal do historico precisa pertencer ao usuario logado

- Method: GET
- EndPoint: /api/historico/{historico_id}
- Headers: "Authorization: Bearer {{token}}"|"Accept: application/json"
- Response:
````json
{
    "data": {
        "id": 4,
        "peso": 50.25,
        "altura": 120,
        "data": "14/03/2018"
    },
    "success": true
}
````

####Atualiza historico do animal
Este método cria um historico para o animal do tipo pessoal
O animal em questão precisa pertencer ao usuario logado

- Method: PUT
- EndPoint: /api/historico/{historico_id}
- Headers: "Authorization: Bearer {{token}}"|"Accept: application/json"
- Request:
````json
{
	"peso": 50.35,
	"altura": 120,
	"data": "14/03/2018"
}
````
- Response:
````json
{
    "data": {
        "id": 6,
        "peso": 50.35,
        "altura": 120,
        "data": "14/03/2018"
    },
    "success": true
}
````

####Remove historico do animal
Este método cria um historico para o animal do tipo pessoal
O animal em questão precisa pertencer ao usuario logado

- Method: DELETE
- EndPoint: /api/historico/{historico_id}
- Headers: "Authorization: Bearer {{token}}"|"Accept: application/json"
- Response:
````json
{
    "data": {
        "id": 4,
        "peso": 50.25,
        "altura": 120,
        "data": "14/03/2018"
    },
    "success": true
}
````

###Lembrete

####Lista lembretes do animal
Este método é para ver um lembrete
Para ver o lembrete, o animal do lembrete precisa pertencer ao usuario logado

- Method: GET
- EndPoint: /api/animal/{animal_id}/lembretes
- Headers: "Authorization: Bearer {{token}}"|"Accept: application/json"
- Response:
````json
{
    "data": [
        {
            "id": 6,
            "nome": "Teste Lembrete",
            "descricao": "Teste Descricao LEmbrete",
            "data_notificacao": "14/03/2018",
            "hora_notificacao": "18:15",
            "data_hora": "14/03/2018 18:15",
            "data_hora_label": "em 8 horas"
        },
        {
            "id": 7,
            "nome": "Teste Lembrete",
            "descricao": "Teste Descricao LEmbrete",
            "data_notificacao": "14/03/2018",
            "hora_notificacao": "18:15",
            "data_hora": "14/03/2018 18:15",
            "data_hora_label": "em 8 horas"
        }
    ],
    "links": {
        "first": "http://localhost:8000/api/animal/36/lembretes?page=1",
        "last": "http://localhost:8000/api/animal/36/lembretes?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "path": "http://localhost:8000/api/animal/36/lembretes",
        "per_page": 10,
        "to": 4,
        "total": 4
    },
    "success": true
}
````

####Criar lembrete para o animal
Este método cria um lembrete para o animal do tipo pessoal
O animal em questão precisa ser do tipo pessoal
O animal em questão precisa pertencer ao usuario logado

- Method: POST
- EndPoint: /api/animal/{animal_id}/lembrete
- Headers: "Authorization: Bearer {{token}}"|"Accept: application/json"
- Request:
````json
{
	"nome": "Teste Lembrete",
	"descricao": "Teste Descricao Lembrete",
	"data_notificacao": "14/03/2018 18:15"
}
````
- Response:
````json
{
    "data": {
        "id": 4,
        "nome": "Teste Lembrete",
        "descricao": "Teste DEscricao LEmbrete",
        "data_notificacao": "14/03/2018",
        "hora_notificacao": "18:15",
        "data_hora": "14/03/2018 18:15",
        "data_hora_label": "em 8 horas"
    },
    "success": true
}
````

####Ver lembrete para o animal
Este método é para ver um lembrete
Para ver o lembrete, o animal do lembrete precisa pertencer ao usuario logado

- Method: GET
- EndPoint: /api/lembrete/{lembrete_id}
- Headers: "Authorization: Bearer {{token}}"|"Accept: application/json"
- Response:
````json
{
    "data": {
        "id": 4,
        "nome": "Teste Lembrete",
        "descricao": "Teste Descricao Lembrete",
        "data_notificacao": "14/03/2018",
        "hora_notificacao": "18:15",
        "data_hora": "14/03/2018 18:15",
        "data_hora_label": "em 8 horas"
    },
    "success": true
}
````

####Atualiza lembrete do animal
Este método cria um lembrete para o animal do tipo pessoal
O animal em questão precisa ser do tipo pessoal
O animal em questão precisa pertencer ao usuario logado

- Method: PUT
- EndPoint: /api/lembrete/{lembrete_id}
- Headers: "Authorization: Bearer {{token}}"|"Accept: application/json"
- Request:
````json
{
	"nome": "Teste Lembrete Update",
	"descricao": "Teste Descricao Lembrete Update",
	"data_notificacao": "15/03/2018 18:15"
}
````
- Response:
````json
{
    "data": {
        "id": 4,
        "nome": "Teste Lembrete Update",
        "descricao": "Teste Descricao Lembrete Update",
        "data_notificacao": "15/03/2018",
        "hora_notificacao": "18:15",
        "data_hora": "14/03/2018 18:15",
        "data_hora_label": "em 8 horas"
    },
    "success": true
}
````

####Remove lembrete do animal
Este método cria um lembrete para o animal do tipo pessoal
O animal em questão precisa ser do tipo pessoal
O animal em questão precisa pertencer ao usuario logado

- Method: DELETE
- EndPoint: /api/lembrete/{lembrete_id}
- Headers: "Authorization: Bearer {{token}}"|"Accept: application/json"
- Response:
````json
{
    "data": {
        "id": 4,
        "nome": "Teste Lembrete Update",
        "descricao": "Teste Descricao Lembrete Update",
        "data_notificacao": "15/03/2018",
        "hora_notificacao": "18:15",
        "data_hora": "14/03/2018 18:15",
        "data_hora_label": "em 8 horas"
    },
    "success": true
}
````

###Mensagens
As notificações das mensagens serão enviadas via push //TODO testar push notification

####Enviar Mensagem
Para enviar uma mensagem, você deve mandar uma mensagem para outra pessoa, que não seja você mesmo ou o usuario precisa existir
Na criação da mensagem, será enviado um push notification para o destinatario. //TODO Testar
- Method: POST
- EndPoint: /api/mensagem/{dono_id}
- Headers: "Authorization: Bearer {{token}}"|"Accept: application/json"
- Request: 
````json
{
	"texto": "insira o texto aqui"
}
````
- Response:
````json
{
    "data": {
        "id": 52,
        "texto": "insira a mensagem aqui",
        "destinatario": {
            "id": 4,
            "nome": "Jasmin Zaragoça Delatorre Jr."
        },
        "remetente": {
            "id": 1,
            "nome": "Dr. Mia Furtado Montenegro"
        },
        "data": "12/03/2018",
        "hora": "12:43:04",
        "data_hora_label": "há 1 segundo",
        "aberto": 0
    },
    "success": true
}
````

####Abrir uma mensagem
Uma mensagem já é aberta ao trazer ela na listagem de historico de mensagem, caso o usuario que solicitou for o destinatario

####Historico de mensagens
Ao ver o historico, deve-se mandar o id do dono em questão que deseja ver o historico

- Method: GET
- EndPoint: /api/mensagens/{dono_id}
- Headers: "Authorization: Bearer {{token}}"|"Accept: application/json"
- Response:
````json
{
    "data": [
        {
            "id": 54,
            "texto": "insira a mensagem aqui",
            "destinatario": {
                "id": 3,
                "nome": "Andres Anderson Marques Jr."
            },
            "remetente": {
                "id": 1,
                "nome": "Dr. Mia Furtado Montenegro"
            },
            "data": "12/03/2018",
            "hora": "12:48:12",
            "data_hora_label": "há 10 minutos",
            "aberto": 0
        },
        {
            "id": 55,
            "texto": "insira a mensagem aqui",
            "destinatario": {
                "id": 3,
                "nome": "Andres Anderson Marques Jr."
            },
            "remetente": {
                "id": 1,
                "nome": "Dr. Mia Furtado Montenegro"
            },
            "data": "12/03/2018",
            "hora": "12:53:08",
            "data_hora_label": "há 5 minutos",
            "aberto": 1,
            "aberto_data": "12/03/2018",
            "aberto_hora": "12/03/2018",
            "aberto_data_hora_label": "há 5 minutos"
        }
    ],
    "success": true
}
````

###Cartões

####Criar um cartão
Para o método criar cartão, deve-se passar o hash gerado pelo moip e a bandeira do cartão, que pode ser obtida na geração do hash do cartão
O campo nome completo precisa de pelo menos 2 nomes
- Method: POST
- EndPoint: /api/cartao
- Headers: "Authorization: Bearer {{token}}"|"Accept: application/json"
- Request: 
````json
{
	"hash": "GkJni2EfIHjrkWeyNGY2tpuwKA28aa4HHSYfBx9YIlJFY0bWyisG4R/LPlqR/RaWg6jDvN4q9s4EIxIjHK2IA6XWrh8ODmKZ0o0igQ9/LyuN7fuzs59xmwhlJmsHj237yBziGtalqcIliY8OywK9lE28JX4lhUQxyeLGEW6raMzBL9xNQJ0aJzg6llPmg4p25lH5GGiX0YnPKeGC8ZbEBhY50STyyBFs8soyl4dGTWxV6XcEEOKYBWO6wNObsswjxAbB2BTMvSoggM6UzuwZp/P/IB4MYz/wfh5dmj03yPDrwaGe4J4UyXbmif7R4tD/98kfJConOsVL0YRnF24Pvg==",
	"ultimos_digitos": "1324",
	"bandeira": "VISA",
	"nome_completo": "Teste Cartao",
	"data_nascimento": "04/06/1995",
	"cpf": "052.878.501-07",
	"telefone": "(41)99770-3592",
	"cep": "81750-410",
	"rua": "Rua Teste",
	"numero": 123,
	"bairro": "Alto Boqueirao",
	"cidade": "Curitiba",
	"estado": "PR"
}
````
- Response:
````json
{
    "data": {
        "id": 16,
        "ultimos_digitos": 1324,
        "bandeira": "VISA"
    },
    "success": true
}
````

####Listar cartões
Para o método criar cartão, deve-se passar o hash gerado pelo moip e a bandeira do cartão, que pode ser obtida na geração do hash do cartão
O campo nome completo precisa de pelo menos 2 nomes
- Method: GET
- EndPoint: /api/cartoes
- Headers: "Authorization: Bearer {{token}}"|"Accept: application/json"

- Response:
````json
{
    "data": [
        {
            "id": 16,
            "ultimos_digitos": 1324,
            "bandeira": "VISA"
        },
        {
            "id": 17,
            "ultimos_digitos": 1324,
            "bandeira": "MASTERCARD"
        },
        {
            "id": 18,
            "ultimos_digitos": 1324,
            "bandeira": "MASTERCARD"
        }
    ],
    "success": true
}
````