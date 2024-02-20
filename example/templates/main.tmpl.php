<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $name ?? '' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <c-container>
        <c-card>
            <c-card::image alt="sunset" />

            <c-card::title>quis exercitation aute aliqua occaecat</c-card::title>

            <c-card::body :red="true" :class="['bg-red-300' => false]">
                sunt anim mollit tempor qui amet ullamco sunt amet tempor elit fugiat sunt voluptate
                et do non ex adipisicing Lorem nisi mollit adipisicing elit dolore enim excepteur do
                ea ullamco incididunt tempor veniam quis reprehenderit excepteur dolore nostrud commodo
                incididunt ex consectetur qui commodo sint mollit excepteur tempor ex sunt
            </c-card::body>
        </c-card>
    </c-container>
</body>

</html>