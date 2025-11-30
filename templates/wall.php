<?php 
require 'header.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
                $message->create($_SESSION['user_id'], $_POST['content']);
                break;
            case 'update':
                $message->update($_POST['id'], $_SESSION['user_id'], $_POST['content']);
                break;
            case 'delete':
                $message->delete($_POST['id'], $_SESSION['user_id']);
                break;
        }
        redirect('index.php');
    }
}

$messages = $message->getAll();
?>

<div class="card mb-4">
    <div class="card-body">
        <form method="post">
            <input type="hidden" name="action" value="create">
            <div class="mb-3">
                <textarea name="content" class="form-control" rows="3" placeholder="Что у вас на уме?" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Опубликовать</button>
        </form>
    </div>
</div>

<?php foreach ($messages as $msg): ?>
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between">
            <strong><?= h($msg['author_name']) ?></strong>
            <small class="text-muted">
                <?= (new DateTime($msg['created_at']))->format('d.m.Y H:i') ?>
                <?php if ($msg['created_at'] !== $msg['updated_at']): ?>
                    (отредактировано)
                <?php endif; ?>
            </small>
        </div>
        <div class="card-body">
            <?php if (isset($_GET['edit']) && $_GET['edit'] == $msg['id'] && $message->canEditOrDelete($msg)): ?>
                <form method="post">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="<?= $msg['id'] ?>">
                    <textarea name="content" class="form-control mb-2" rows="3" required><?= h($msg['content']) ?></textarea>
                    <button type="submit" class="btn btn-success btn-sm">Сохранить</button>
                    <a href="index.php" class="btn btn-secondary btn-sm">Отмена</a>
                </form>
            <?php else: ?>
                <p class="card-text"><?= nl2br(h($msg['content'])) ?></p>
                <?php if ($message->canEditOrDelete($msg)): ?>
                    <div class="mt-2">
                        <a href="index.php?edit=<?= $msg['id'] ?>" class="btn btn-outline-primary btn-sm">Редактировать</a>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= $msg['id'] ?>">
                            <button type="submit" class="btn btn-outline-danger btn-sm" 
                                    onclick="return confirm('Удалить сообщение?')">Удалить</button>
                        </form>
                        <small class="text-muted ms-3">
                            Редактировать/удалить можно только в течение <?= HOURS_TO_EDIT ?> часа
                        </small>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>

<?php require 'footer.php'; ?>