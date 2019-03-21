## Разворачивание проекта
1) git clone https://github.com/Wheiss/contradmin.git
2) Настроить сервер(в моем случае nginx), вот пример конфига:
3) Настроить права(в моем случае нужно было создать папку для логов и проставить на нее права как для пользователя сервера)
4) Добавить адреса в hosts
    ```php
    server {
            charset utf-8;
            client_max_body_size 128M;
    
            listen 80; ## listen for ipv4
            #listen [::]:80 default_server ipv6only=on; ## listen for ipv6
    
            server_name contradmin.me;
            root        /home/nick/dev/web/contradmin/frontend/web/;
            index       index.php;
    
            access_log  /home/nick/dev/web/contradmin/log/frontend-access.log;
            error_log   /home/nick/dev/web/contradmin/log/frontend-error.log;
    
            location / {
                # Redirect everything that isn't a real file to index.php
                try_files $uri $uri/ /index.php$is_args$args;
            }
    
            # uncomment to avoid processing of calls to non-existing static files by Yii
            #location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
            #    try_files $uri =404;
            #}
            #error_page 404 /404.html;
    
            # deny accessing php files for the /assets directory
            location ~ ^/assets/.*\.php$ {
                deny all;
            }
    
            location ~ \.php$ {
                include fastcgi_params;
                fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
                fastcgi_pass 127.0.0.1:9000;
                #fastcgi_pass unix:/var/run/php5-fpm.sock;
                try_files $uri =404;
            }
        
            location ~* /\. {
                deny all;
            }
        }
         
        server {
            charset utf-8;
            client_max_body_size 128M;
        
            listen 80; ## listen for ipv4
            #listen [::]:80 default_server ipv6only=on; ## listen for ipv6
        
            server_name backend.contradmin.me;
            root        /home/nick/dev/web/contradmin/backend/web/;
            index       index.php;
        
            access_log  /home/nick/dev/web/contradmin/log/backend-access.log;
            error_log   /home/nick/dev/web/contradmin/log/backend-error.log;
        
            location / {
                # Redirect everything that isn't a real file to index.php
                try_files $uri $uri/ /index.php$is_args$args;
            }
        
            # uncomment to avoid processing of calls to non-existing static files by Yii
            #location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
            #    try_files $uri =404;
            #}
            #error_page 404 /404.html;
    
            # deny accessing php files for the /assets directory
            location ~ ^/assets/.*\.php$ {
                deny all;
            }
    
            location ~ \.php$ {
                include fastcgi_params;
                fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
                fastcgi_pass 127.0.0.1:9000;
                #fastcgi_pass unix:/var/run/php5-fpm.sock;
                try_files $uri =404;
            }
        
            location ~* /\. {
                deny all;
            }
        }
    
    ```
5) composer update
6) Создать локальный конфиг touch ./common/config/main-local.php
7) ./init
8) Прописать в локальном конфиге доступ к бд
9) php yii rbac/init
10) Настроить подключение к бд в common/config/main-local
11) php yii migrate


### Что сделано
0) Все комменты в проекте на английском... Привычка писать дома так и когда я задумался о том, что стоило бы писать на русском,- половина уже была сделана, поэтому решил продолжить до конца. 
1) Разделенные frontend и backend панели
В backend может зайти только пользователь с правами админа.
В frontend может зайти любой пользователь, но страницы операций контрагента будут видны только пользователям с ролью контрагент.
Роли хранятся по дефолту(Имеется в виду дефолт для Yii) в файлах.
2) Интерфейс контрагента: после входа контрагент может перейти на страницу списка его операций, там показывается его баланс и есть кнопка добавления операции, которая ведет на форму добавления.
3) Панель админа: после входа доступны страницы импорта операций, список операций с кнопкой создания новой и список контрагентов
4) Импорт операций: сделано очень просто - загружается файл и ожидается, что он будет строгого формата(минимальная реализация задачи), колонки должны идти в строгом порядке. Берутся по очереди все листы, со всех листов берутся подряд ряды, когда попадается пустой ряд разбор листа прекращается. Если данные ряда невалидны - ряд будет пропущен и в форме будет выведена ошибка.
5) Из опционального точно сделана только регистрация, восстановление пароля возможно работает - не проверял
6) Определение попыток контрагентов доступа в админку не сделал в первую очередь потому что это опционально, а хочется побыстрее сдать задачу.