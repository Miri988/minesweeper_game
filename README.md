# minesweeper_game
Игра Сапер
Задача:
Разработать веб-приложение, позволяющее играть в Сапер. Лишь зарегистрированные и вошедшие в учетную запись пользователи могут играть. Гость (пользователь, который не вошел в учетную запись) при попытке открыть любую страницу (кроме: страницы входа в учетную запись и страницы регистрации) перенаправляется на страницу входа в учетную запись.

На главной странице приложение должно отображать топ-10 игроков (по количеству побед).

Если пользователь покинул страницу после начала игры, приложение должно сохранить текущий результат и предоставить возможность продолжить игру.

Страница Вход в учетную запись:
Предоставляет возможность пользователю войти в учетную запись при помощи логина и пароля. Если были введены неверные данные - отображается ошибка.

Рядом с формой входа в учетную запись должна быть расположена ссылка, которая позволит пользователю пройти регистрацию.

Если введены верные логин и пароль, приложение отображает Главную страницу.

Страница Регистрации учетной записи:
Предоставляет возможность создать учетную запись. Для регистрации требуется ввести: логин, пароль, повторить пароль, имя, фамилию, дату рождения.

Если пользователь зарегистрирован успешно, приложение отображает страницу Вход в учетную запись.

Главная страница:
На данной странице пользователь может видеть топ-10 игроков, а также ссылку, чтобы начать новую игру (либо продолжить старую).

Страница игры Сапер:
Отображает поле игры и количество использованных флажков.

Технические требования:
PHP, CSS, HTML (JS при необходимости)
для хранения информации допускается использовать файловую базу данных
