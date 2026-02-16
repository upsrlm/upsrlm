
        <div class="container-fluid px-5 mx-5" >
            <div class="row">
                <div class="col-12">                   
                    <ul class="timeline">
                        <?php
                        $no = 1;
                        foreach ($model as $key => $go) {
                            ?>
                            <li class="event" data-date="<?=$go['time']?>">
                                <h3></h3>
                                <p>
                                    <?=$go['title']?>
                                </p>
                                <a href=""><img src="/images/pdficon.png" alt="" width="40" ></a>
                            </li>

                            <?php
                            $no++;
                        }
                        ?>


                    </ul>
                </div>
            </div>
        </div>

