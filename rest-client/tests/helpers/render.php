<?php
/**
 * Helper untuk automated testing: salinan verbatim dari logika rendering
 * index.php (loop $hasil['articles']) sehingga bisa diuji tanpa browser.
 * TIDAK mengubah kode produksi apa pun.
 */
function render_articles(array $hasil): string
{
    ob_start();
    foreach ($hasil['articles'] as $row) { ?>
            <div class="col-md" style="margin-top: 10px; margin-bottom: 10px;">
                <div class="card" style="width: 18rem;">
                    <img src="<?php echo $row['urlToImage']; ?>" class="card-img-top" height="180px">
                    <div class="card-body">
                        <p class="card-text"><i>Oleh <?php echo $row['author']; ?></i> ~ <?php echo $row['title']; ?></p>
                        <p class="text-right"><a href="<?php echo $row['urlToImage']; ?>" target="_blank">Selengkapnya..</a></p>
                    </div>
                </div>
            </div>
    <?php }
    return ob_get_clean();
}
