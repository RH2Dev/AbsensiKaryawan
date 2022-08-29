<?php $pager->setSurroundCount(2) ?>

<nav aria-label="Page navigation">
    <ul class="pagination">
    <?php if ($pager->hasPrevious()) : ?>
        <li class="page-item">
            <a class="page-link" href="<?php echo $pager->getFirst() ?>" aria-label="<?php echo lang('Pager.first') ?>">
                <span aria-hidden="true"><?php echo lang('Pager.first') ?></span>
            </a>
        </li>
        <li class="page-item">
            <a class="page-link" href="<?php echo $pager->getPreviousPage() ?>" aria-label="<?php echo lang('Pager.previous') ?>">
                <span aria-hidden="true"><?php echo lang('Pager.previous') ?></span>
            </a>
        </li>
    <?php endif ?>

    <?php foreach ($pager->links() as $link): ?>
        <li class="page-item <?php echo $link['active'] ? 'active' : '' ?>">
            <a class="page-link" href="<?php echo $link['uri'] ?>">
                <?php echo $link['title'] ?>
            </a>
        </li>
    <?php endforeach ?>

    <?php if ($pager->hasNext()) : ?>
        <li class="page-item">
            <a class="page-link" href="<?php echo $pager->getNextPage() ?>" aria-label="<?php echo lang('Pager.next') ?>">
                <span aria-hidden="true"><?php echo lang('Pager.next') ?></span>
            </a>
        </li>
        <li class="page-item">
            <a class="page-link" href="<?php echo $pager->getLast() ?>" aria-label="<?php echo lang('Pager.last') ?>">
                <span aria-hidden="true"><?php echo lang('Pager.last') ?></span>
            </a>
        </li>
    <?php endif ?>
    </ul>
</nav>