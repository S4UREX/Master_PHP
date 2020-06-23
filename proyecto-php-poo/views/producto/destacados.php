<h1>Algunos de nuestros productos</h1>

<?php while ($pro = $productos->fetch_object()): ?>
    <div class="product ">

        <a href="<?=base_url?>producto/ver&id=<?=$pro->id?>">
            <?php if (!is_null($pro->imagen)): ?>
                <img src="<?=base_url?>uploads/images/<?=$pro->imagen?>">
            <?php else: ?>
                <img src="<?=base_url?>assets/img/camiseta.png">
            <?php endif; ?>

            <h2><?=Utils::recortarPalabras($pro->nombre)?></h2>

        </a>

        <p>$<?=$pro->precio?></p>
        <a href="<?=base_url?>carrito/add&id=<?=$pro->id?>" class="button">Comprar</a>
    </div>
<?php endwhile; ?>