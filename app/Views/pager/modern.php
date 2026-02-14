<?php
$current = $pager->getCurrentPage();
$pageCount = $pager->getPageCount();
$perPage = $pager->getPerPage();
$total = $pager->getTotal();
$from = ($total === 0) ? 0 : (($current - 1) * $perPage + 1);
$to = min($current * $perPage, $total);
?>
<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
  <div class="text-muted small">
    Halaman <?= $current ?>/<?= $pageCount ?> · Menampilkan <?= $from ?>–<?= $to ?> dari <?= $total ?>
  </div>
  <nav aria-label="Pagination">
    <ul class="pagination pagination-sm mb-0">
      <li class="page-item <?= $pager->hasPrevious() ? '' : 'disabled' ?>">
        <a class="page-link" href="<?= $pager->hasPrevious() ? $pager->getFirst() : '#' ?>" aria-label="First">
          <span aria-hidden="true">«</span>
        </a>
      </li>
      <li class="page-item <?= $pager->hasPrevious() ? '' : 'disabled' ?>">
        <a class="page-link" href="<?= $pager->hasPrevious() ? $pager->getPreviousPageURI() : '#' ?>" aria-label="Previous">
          <span aria-hidden="true">‹</span>
        </a>
      </li>
      <?php foreach ($pager->links() as $link): ?>
        <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
          <a class="page-link" href="<?= $link['uri'] ?>"><?= $link['title'] ?></a>
        </li>
      <?php endforeach ?>
      <li class="page-item <?= $pager->hasNext() ? '' : 'disabled' ?>">
        <a class="page-link" href="<?= $pager->hasNext() ? $pager->getNextPageURI() : '#' ?>" aria-label="Next">
          <span aria-hidden="true">›</span>
        </a>
      </li>
      <li class="page-item <?= $pager->hasNext() ? '' : 'disabled' ?>">
        <a class="page-link" href="<?= $pager->hasNext() ? $pager->getLast() : '#' ?>" aria-label="Last">
          <span aria-hidden="true">»</span>
        </a>
      </li>
    </ul>
  </nav>
  </div>
