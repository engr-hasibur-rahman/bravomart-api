
<h2>System Requirements</h2>

<ul>
    <li>PHP Version (>= 8.1): <?= $requirements['php'] ? '✔️' : '❌' ?> (<?= PHP_VERSION ?>)</li>
</ul>

<h3>Required Extensions</h3>
<ul>
    <?php foreach ($requirements['extensions'] as $ext => $status): ?>
        <li><?= strtoupper($ext) ?>: <?= $status ? '✔️ Enabled' : '❌ Missing' ?></li>
    <?php endforeach; ?>
</ul>

<a href="?step=permissions">Next</a>
