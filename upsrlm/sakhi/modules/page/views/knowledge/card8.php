<?php
$this->title = 'संपूर्ण टीकाकरण - सुरझित शिशु'
?>
<div class="row">
    <div class="subheader" style="text-align: center">
        <h1 class="subheader-title">
            <?= $this->title ?>

        </h1>

    </div>
    <div class="row d-flex flex-wrap align-items-center flashimage" data-toggle="modal" data-target="#lightbox">
        <?php foreach ($cards as $key => $img) { ?>
            <div class="flashimage">

                <img src="<?= $img ?>" class="img-fluid" data-target="#indicators" data-slide-to="<?= $key ?>" alt="" /> 
            </div>
        <?php } ?>        

    </div>

    <!-- Modal -->
    <div class="modal fade" id="lightbox" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close text-right p-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div id="indicators" class="carousel slide" data-interval="false">
                    <ol class="carousel-indicators">
                        <?php
                        foreach ($cards as $key => $img) {
                            $active = '';
                            if ($key == 0) {
                                $active = 'active';
                            }
                            ?>
                            <li data-target="#indicators" data-slide-to="<?= $key ?>" class=<?= $active ?>></li>
                        <?php } ?>

                    </ol>
                    <div class="carousel-inner">
                        <?php
                        foreach ($cards as $key => $img) {

                            $active1 = '';
                            if ($key == 0) {
                                $active1 = 'active';
                            }
                            ?>
                            <div class="carousel-item <?= $active1 ?>">

                                <img class="d-block w-100" src="<?= $img ?>" alt="">
                            </div>
<?php } ?>

                    </div>
                    <a class="carousel-control-prev" href="#indicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#indicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
<?php
$style = <<< CSS
 .flashimage img {
  height: auto;
  min-width: 100%;
}
.modal-dialog {
  max-width: 98% !important;
  margin: 1.75rem auto;
}
CSS;
$this->registerCss($style);
?>