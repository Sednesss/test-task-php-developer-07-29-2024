## README.md

### Проект тестового задания

Этот проект предназначен для выполнения тестового задания.

## Необходимые инструменты:

* Docker: Необходимо установить Docker Engine на ваш сервер.
    * [Инструкции по установке Docker](https://docs.docker.com/engine/install/)
* Make: Утилита Make должна быть установлена на вашем сервере. 
    * [Инструкции по установке Make](https://www.gnu.org/software/make/manual/make.html) 

## Установка:

1. Клонируйте репозиторий:
```sh
git clone [URL репозитория]
```
   
2. Перейдите в корневую директорию проекта:
```sh
cd [Имя папки проекта]
```
3. Установите зависимости:
```sh
make dev
```
   
4. Инициализируйте приложение:
```sh
make init-app
```

## Использование:
2. Доступ к документации Swagger:

```
http://localhost/api/documentation
```

3. **Доступ к GraphiQL:**

```
http://localhost/graphiql
```