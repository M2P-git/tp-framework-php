<h1>Interventions ouvertes</h1>
<ul>
<?php foreach ($interventions as $i): ?>
  <li><a href="/interventions/<?= e($i['id']) ?>"><?= e($i['serie']) ?></a> :
      <?= e($i['description']) ?> (<?= e($i['statut']) ?>)</li>
<?php endforeach; ?>
</ul>
<?php if ($interventions === []): ?>
  <p>Aucune intervention ouverte.</p>
<?php endif; ?>
