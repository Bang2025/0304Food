<div class="row">
  <div class="col">
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item">
          <a class="page-link" href="#">
            <i class="fa-solid fa-angles-left"></i>
          </a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#">
            <i class="fa-solid fa-angle-left"></i>
          </a>
        </li>

        <?php for ($i = $page - 5; $i <= $page + 5; $i++):
          if ($i >= 1 and $i <= $totalPages):
            $qs = $_GET; # 複製 $_GET, 包含所有 query string parameters
            $qs['page'] = $i;
        ?>
            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
              <a class="page-link" href="?<?= http_build_query($qs) ?>"><?= $i ?></a>
            </li>
        <?php endif;
        endfor; ?>
        <li class="page-item">
          <a class="page-link" href="#">
            <i class="fa-solid fa-angle-right"></i>
          </a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#">
            <i class="fa-solid fa-angles-right"></i>
          </a>
        </li>

      </ul>
    </nav>
  </div>
</div>
<div class="row">
  <div class="col">
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>姓名(食譜)</th>
          <th>手機(描述)</th>
          <th>電郵(份數)</th>
          <th>地址(喜歡數)</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $r): ?>
          <tr>
            <td><?= $r['recipe_id'] ?></td>
            <td class="search-field"><?= $r['title'] ?></td>
            <td class="search-field"><?= $r['description'] ?></td>
            <td><?= $r['servings'] ?></td>
            <td><?= htmlentities($r['like_count']) ?></td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>