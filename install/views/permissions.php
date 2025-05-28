<h2>Folder Permissions</h2>
<ul>
    <?php foreach ($folders as $folder => $status): ?>
        <li><?= $folder ?>: <?= $status ? '✔️ Writable' : '❌ Not Writable' ?></li>
    <?php endforeach; ?>
</ul>
<a href="?step=environment">Next</a>
