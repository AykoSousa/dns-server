<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <title>DNS Server</title>
</head>
<body>
    <main>
        <div class="container">
            <h1 class="mt-5">Welcome to the DNS Server</h1>
            <h5>Hello, <?php echo htmlspecialchars($_SESSION['user']['username']); ?>!</h5>
            <p>Here you can manage your DNS domains.</p>
            <div class="mt-4">
                <h2>Blocked Domains</h2>
                <ul class="list-group">
                    <?php foreach ($domains as $domain): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo htmlspecialchars($domain['domain']); ?>
                            <form action="/domains/delete" method="POST" class="d-inline">
                                <input type="hidden" name="domainId" value="<?php echo htmlspecialchars($domain['id']); ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <form method="POST" action="/domains" class="mt-3">
                    <div class="input-group">
                        <input type="text" name="domain" class="form-control" placeholder="Add new domain" required>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success mt-3">
                        <?php echo htmlspecialchars($_SESSION['success']); ?>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger mt-3">
                        <?php echo htmlspecialchars($_SESSION['error']); ?>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>
            </div>
            <div class="mt-4">
                <a href="/logout" class="btn btn-secondary">Logout</a>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-7z4c1e2a8f3b8c4d6e4f0a2b8c4d6e4f0a2b8c4d6e4f0a2b8c4d6e4f0a2b8c4" crossorigin="anonymous"></script>
</body>
</html>