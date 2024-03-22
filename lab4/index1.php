<div class="form">
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <fieldset>
      <legend>Оставьте отзыв!</legend>
      <div id="main_info" style="display: flex; flex-direction: column; gap: 10px;">
        <div>
          <label for="name">Имя:
            <input type="text" name="name" />
          </label>
        </div>
        <div>
          <label for="email">Email:
            <input type="email" name="email" />
          </label>
        </div>
      </div>
      <div id="extra_info">
        <div>
          <p><label for="review">Оцените наш сервис!</label></p>
          <div style="display: flex; flex-direction: column;">
            <p><input id="review1" type="radio" name="review" value="10" checked>Хорошо</p>
            <p><input id="review2" type="radio" name="review" value="8">Удовлетворительно</p>
            <p><input id="review3" type="radio" name="review" value="5">Плохо</p>
          </div>
        </div>
      </div>
      <div id="message_info">
        <div>
          <p><label for="comment">Ваш комментарий: </label></p>
          <textarea id="comment" name="comment" cols="30" rows="10" class="comment"></textarea>
        </div>
      </div>
      <div id="buttons" style="display: flex; flex-direction: row; gap: 10px; margin-top: 10px;">
        <input type="submit" value="Отправить" />
        <input type="reset" value="Удалить" />
      </div>
    </fieldset>
  </form>
  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = validateFormData($_POST);

    if (!empty($errors)) {
        echo "<div id='error'>";
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        echo "</div>";
    }
    else
    {
    ?>
    <div id="result">
    <p>Ваше имя: <b><?php echo $_POST["name"] ?></b></p>
    <p>Ваш e-mail: <b><?php echo $_POST["email"] ?></b></p>
    <p>Оценка товара: <b><?php echo $_POST["review"] ?></b></p>
    <p>Ваше сообщение: <b><?php echo $_POST["comment"] ?></b></p>
    </div>
    <?php
    }
  }
  function validateFormData($formData) {
    $errors = array();

    if (empty($formData['name'])) {
        $errors[] = "Имя не заполнено.";
    }
    if (empty($formData['email'])) {
        $errors[] = "Email не заполнен.";
    }
    if (empty($formData['review'])) {
        $errors[] = "Оценка не выбрана.";
    }
    if (empty($formData['comment'])) {
        $errors[] = "Комментарий не заполнен.";
    }

    if (!empty($formData['email']) && !filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Введите корректный e-mail адрес.";
    }

    return $errors;
}
  ?>
</div>
