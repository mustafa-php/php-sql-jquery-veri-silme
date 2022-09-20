<?php
try {
  $_deney = new PDO("mysql:host=localhost;dbname=deney", "root", "");
} catch (PDOException $e) {
  print $e->getMessage();
}


if (isset($_POST["kaydet"])) {
  $baslik = $_POST["baslik"];
  $icerik = $_POST["icerik"];
  $listele = $_deney->prepare("INSERT INTO  listeleme SET baslik=:baslik, icerik=:icerik");
  $listele->execute(array(
    "baslik" => $baslik,
    "icerik" => $icerik
  ));
}

if (isset($_POST["sil"])) {
  $silid = $_POST["sil"];
  $sil = $_deney->prepare("DELETE FROM listeleme WHERE id=:id");
  $sil->execute(
    array(
      "id" => $silid
    )
  );
}

?>
<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Php SQL jQuery Veri Ekleme-Listeleme-Silme</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous" />
  <link rel="stylesheet" href="style.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</head>

<body>

  <div class="form_div">
    <form action="index.php" method="post">
      <input type="text" name="baslik" placeholder="Başlık..."  autocomplete="off"/>
      <textarea name="icerik" placeholder="İçerik..." autocomplete="off" ></textarea>
      <button type="submit" name="kaydet">Kaydet</button>
    </form>
  </div>
  <div class="paylasim_div">
    <?php
    $liste = $_deney->prepare("SELECT * FROM listeleme order by id desc");
    $liste->execute();

    $listeleniyor = $liste->fetchAll(PDO::FETCH_OBJ);

    foreach ($listeleniyor as $sonuc) {
    ?>
      <div class="paylasim">
        <div class="paylasim_bas"><?php echo $sonuc->kullanici_adi; ?></div>
        <div class="paylasim_govde">
          <h2><?php echo $sonuc->baslik; ?></h2>
          <p>
            <?php echo $sonuc->icerik; ?>
          </p>
        </div>
        <div class="paylasim_sil">
          <button class="sil" id="<?php echo $sonuc->id ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
              <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
            </svg>
          </button>
        </div>
      </div>
    <?php } ?>
  </div>
  <script>
    $(document).ready(function() {
      $(".sil").click(function() {

        var id = $(this).attr("id");

        $.ajax({
          type: "post",
          url: "",
          data: {
            sil: id
          },
        });

        $(this).parent().parent(".paylasim").remove();
      });
    });
  </script>
</body>

</html>