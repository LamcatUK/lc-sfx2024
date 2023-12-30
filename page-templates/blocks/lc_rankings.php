<section class="rankings mb-2">
    <div class="container-xl bg-white py-4">
        <h2 class="headline mb-2 text-primary-900 fs-700">Rankings</h2>
        <div class="row">
            <div class="col-lg-6">
                <h3 class="headline mb-2 text-primary-900 fs-600">Men</h3>
                <?php
$q = new WP_Query(array(
    'post_type' => 'fighters',
    'posts_per_page' => -1,
    'meta_query' => array(
        array(
          'key' => 'sex',
          'value' => 'Male',
          'compare' => '=',
        )
    )
));
                $results = array();
                while ($q->have_posts()) {
                    $q->the_post();
                    $row = fight_history(get_the_ID());
                    $win_count = 0;
                    $loss_count = 0;
                    $draw_count = 0;
                    $matches = 0;
                    $points = 0;
                    foreach ($row as $r) {
                        $result = $r["result"];
                        if ($result === "Win") {
                            $win_count++;
                            $points += 3;
                        } elseif ($result === "Loss") {
                            $loss_count++;
                            $points += 1;
                        } elseif ($result === "Draw") {
                            $draw_count++;
                            $points += 2;
                        }
                        $matches++;
                    }
                    $results[] = array(
                        'id' => get_the_ID(),
                        'points' => $points,
                        'matches' => $matches,
                        'wins' => $win_count,
                        'losses' => $loss_count,
                        'draw'  => $draw_count,
                    );
                }

                usort($results, function ($a, $b) {
                    return $b['points'] - $a['points'];
                });

                ?>
                <div class="filterButtons">
                    <button class="showAllButton is-checked" data-table="mens">All Classes</button>
                    <button class="filterButton" data-table="mens" data-class="60kg">&lt;60kg</button>
                    <button class="filterButton" data-table="mens" data-class="70kg">&lt;70kg</button>
                    <button class="filterButton" data-table="mens" data-class="80kg">&lt;80kg</button>
                    <button class="filterButton" data-table="mens" data-class="90kg">&lt;90kg</button>
                    <button class="filterButton" data-table="mens" data-class="90kg-2">&gt;90kg</button>
                </div>

                <table class="table table-sm table-striped fs-200" id="mens">
                    <thead>
                        <tr class="headline fs-300">
                            <th>Name</th>
                            <th>Class</th>
                            <th>Points</th>
                            <th>Bouts</th>
                            <th>Wins</th>
                            <th>Losses</th>
                            <th>Draws</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                foreach ($results as $r) {
                    ?>
                        <tr
                            class="<?=get_field('weight_class', $r['id'])->slug?>">
                            <td><a class="fw-900"
                                    href="<?=get_the_permalink($r['id'])?>"><?=get_the_title($r['id'])?></a>
                            </td>
                            <td><?=get_field('weight_class', $r['id'])->name?>
                            <td><?=$r['points']?>
                            </td>
                            <td><?=$r['matches']?>
                            </td>
                            <td><?=$r['wins']?>
                            </td>
                            <td><?=$r['losses']?>
                            </td>
                            <td><?=$r['draw']?>
                            </td>
                        </tr>
                        <?php
                }
                ?>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-6">
                <h3 class="headline mb-2 text-primary-900 fs-600">Ladies</h3>
                <?php
$q = new WP_Query(array(
    'post_type' => 'fighters',
    'posts_per_page' => -1,
    'meta_query' => array(
                array(
                  'key' => 'sex',
                  'value' => 'Female',
                  'compare' => '=',
                )
    )
));
                $results = array();
                while ($q->have_posts()) {
                    $q->the_post();
                    $row = fight_history(get_the_ID());
                    $win_count = 0;
                    $loss_count = 0;
                    $draw_count = 0;
                    $matches = 0;
                    $points = 0;
                    foreach ($row as $r) {
                        $result = $r["result"];
                        if ($result === "Win") {
                            $win_count++;
                            $points += 3;
                        } elseif ($result === "Loss") {
                            $loss_count++;
                            $points += 1;
                        } elseif ($result === "Draw") {
                            $draw_count++;
                            $points += 2;
                        }
                        $matches++;
                    }
                    $results[] = array(
                        'id' => get_the_ID(),
                        'points' => $points,
                        'matches' => $matches,
                        'wins' => $win_count,
                        'losses' => $loss_count,
                        'draw'  => $draw_count,
                    );
                }

                usort($results, function ($a, $b) {
                    return $b['points'] - $a['points'];
                });

                ?>
                <div class="filterButtons">
                    <button class="showAllButton is-checked" data-table="ladies">All Classes</button>
                    <button class="filterButton" data-table="ladies" data-class="ladies-55kg">&lt;55kg</button>
                    <button class="filterButton" data-table="ladies" data-class="ladies-65kg">&lt;65kg</button>
                    <button class="filterButton" data-table="ladies" data-class="ladies-75kg">&lt;75kg</button>
                    <button class="filterButton" data-table="ladies" data-class="ladies-75kg">&gt;75kg</button>
                </div>


                <table class="table table-sm table-striped fs-200" id="ladies">
                    <thead>
                        <tr class="headline fs-300">
                            <th>Name</th>
                            <th>Class</th>
                            <th>Points</th>
                            <th>Bouts</th>
                            <th>Wins</th>
                            <th>Losses</th>
                            <th>Draws</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                foreach ($results as $r) {
                    ?>
                        <tr
                            class="<?=get_field('weight_class', $r['id'])->slug?>">
                            <td><a class="fw-900"
                                    href="<?=get_the_permalink($r['id'])?>"><?=get_the_title($r['id'])?></a>
                            </td>
                            <td><?=get_field('weight_class', $r['id'])->name?>
                            <td><?=$r['points']?>
                            </td>
                            <td><?=$r['matches']?>
                            </td>
                            <td><?=$r['wins']?>
                            </td>
                            <td><?=$r['losses']?>
                            </td>
                            <td><?=$r['draw']?>
                            </td>
                        </tr>
                        <?php
                }
                ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const showAllButtons = document.querySelectorAll(".showAllButton");
        const filterButtons = document.querySelectorAll(".filterButton");

        function setActiveButton(tableId, clickedButton) {
            const buttons = document.querySelectorAll(`[data-table="${tableId}"]`);
            buttons.forEach(function(button) {
                if (button === clickedButton) {
                    button.classList.add("is-checked");
                } else {
                    button.classList.remove("is-checked");
                }
            });
        }

        showAllButtons.forEach(function(showAllButton) {
            showAllButton.addEventListener("click", function() {
                const tableId = showAllButton.getAttribute("data-table");
                const tableRows = document.querySelectorAll(`#${tableId} tbody tr`);
                tableRows.forEach(function(row) {
                    row.style.display = "";
                });
                setActiveButton(tableId, showAllButton);
            });
        });

        filterButtons.forEach(function(button) {
            button.addEventListener("click", function() {
                const tableId = button.getAttribute("data-table");
                const classToShow = button.getAttribute("data-class");
                const tableRows = document.querySelectorAll(`#${tableId} tbody tr`);
                tableRows.forEach(function(row) {
                    if (row.classList.contains(classToShow)) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
                setActiveButton(tableId, button);
            });
        });
    });
</script>