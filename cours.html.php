<?php
include 'connexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST["date"];
    $heurededebut = $_POST["heurededebut"];
    $heuredefin = $_POST["heuredefin"];
    $module = $_POST["module"];
    $professeur = $_POST["professeur"];
    $classe = $_POST["classe"];

    $sql = "INSERT INTO cours (date, heurededebut, heuredefin, module, professeur, classe) 
            VALUES (:date, :heurededebut, :heuredefin, :module, :professeur, :classe)";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':heurededebut', $heurededebut);
        $stmt->bindParam(':heuredefin', $heuredefin);
        $stmt->bindParam(':module', $module);
        $stmt->bindParam(':professeur', $professeur);
        $stmt->bindParam(':classe', $classe);

        if ($stmt->execute()) {
            header("Location: cours.php");
            exit();
        } else {
            print_r($stmt->errorInfo());
        }
    } catch (PDOException $e) {
        echo "Erreur lors de l'insertion : " . $e->getMessage();
    }
}

try {
    $query = "SELECT * FROM cours";
    $result = $pdo->query($query);
    $cours = $result->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des données : " . $e->getMessage();
}
?>


<!doctype html>
<html lang="en">

<head>
    <title>Cours</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Ajouter un Cours</h2>
        <form method="post" action="">
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="mb-3">
                <label for="heurededebut" class="form-label">Heure de Début</label>
                <input type="time" class="form-control" id="heurededebut" name="heurededebut" required>
            </div>
            <div class="mb-3">
                <label for="heuredefin" class="form-label">Heure de Fin</label>
                <input type="time" class="form-control" id="heuredefin" name="heuredefin" required>
            </div>
            <div class="mb-3">
                <label for="module" class="form-label">Module</label>
                <input type="text" class="form-control" id="module" name="module" required>
            </div>
            <div class="mb-3">
                <label for="professeur" class="form-label">Professeur</label>
                <input type="text" class="form-control" id="professeur" name="professeur" required>
            </div>
            <div class="mb-3">
                <label for="classe" class="form-label">Classe</label>
                <input type="text" class="form-control" id="classe" name="classe" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Plannifier</button>
        </form>

        <h2 class="text-center my-4">Liste des Cours</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Heure Début</th>
                    <th>Heure Fin</th>
                    <th>Module</th>
                    <th>Professeur</th>
                    <th>Classe</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($cours)) : ?>
                    <?php foreach ($cours as $index => $row) : ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($row['date']) ?></td>
                            <td><?= htmlspecialchars($row['heurededebut']) ?></td>
                            <td><?= htmlspecialchars($row['heuredefin']) ?></td>
                            <td><?= htmlspecialchars($row['module']) ?></td>
                            <td><?= htmlspecialchars($row['professeur']) ?></td>
                            <td><?= htmlspecialchars($row['classe']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="text-center">Aucun cours trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>



    <script>
        document.getElementById('ajoutcourForm').addEventListener('submit', function(event) {
            let valid = true;

            const date = document.getElementById('date');
            const heurededebut = document.getElementById('heurededebut');
            const email = document.getElementById('email');
            const professeur = document.getElementById('professeur');
            const classe = document.getElementById('classe');
            const grade = document.getElementById('grade');

            if (date.value.trim() === '') {
                document.getElementById('dateError').textContent = 'La date est requis.';
                date.classList.add('is-invalid');
                valid = false;
            } else {
                document.getElementById('dateError').textContent = '';
                date.classList.remove('is-invalid');
            }

            if (heurededebut.value.trim() === '') {
                document.getElementById('heurededebutError').textContent = 'Lheure est requis.';
                heurededebut.classList.add('is-invalid');
                valid = false;
            } else {
                document.getElementById('heurededebutError').textContent = '';
                heurededebut.classList.remove('is-invalid');
            }


            if (professeur.value.trim() === '') {
                document.getElementById('dateError').textContent = 'veillez remplir';
                professeur.classList.add('is-invalid');
                valid = false;
            } else {
                document.getElementById('dateError').textContent = '';
                professeur.classList.remove('is-invalid');
            }


            if (!valid) {
                event.preventDefault();
            } else {
                document.getElementById('ajoutcourForm').reset();
            }
        });
    </script>
</body>

</html>