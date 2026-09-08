<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskMaster</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="reset.css">
</head>
<body>
    

    <?php

require "db.php";
        
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}    
 
$user_id = $_SESSION["user_id"];

$filter = $_GET["filter"] ?? "all";


$search = $_GET["search"] ?? "";


$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i" , $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();



if ($filter === "all"){
    
    if ($search === ""){
    $stmt= $conn ->prepare("SELECT * FROM tasks WHERE user_id = ?");
    
    $stmt ->bind_param("i" , $user_id);
    }else{
        $searchTerm = "%" . $search . "%";

        $stmt = $conn ->prepare("SELECT * FROM tasks WHERE user_id = ? AND (title LIKE ? OR description LIKE ?)");
        $stmt ->bind_param("iss" , $user_id , $searchTerm , $searchTerm);
    }
    }
  
    
    
    
    
    elseif ($filter === "today") {
    

        if($search === ""){
            $stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ? AND DATE(due_date) = CURDATE()");
            $stmt->bind_param("i" , $user_id);
        }else{
                $searchTerm = "%" . $search . "%";
                $stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ? AND DATE(due_date) = CURDATE() AND (title LIKE ? OR description LIKE ?)");
                $stmt->bind_param("iss" , $user_id , $searchTerm , $searchTerm);
        }


}
elseif ($filter === "upcoming"){

        if($search === ""){
        $stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ? AND DATE(due_date) > CURDATE()");
        $stmt ->bind_param("i" , $user_id);
        }else{

            $searchTerm = "%" . $search. "%";

            $stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ? AND DATE(due_date) > CURDATE() AND (title LIKE ? OR description LIKE ?)");
            $stmt->bind_param("iss" , $user_id , $searchTerm , $searchTerm);
        }

   


    
}elseif ($filter === "completed"){
    if($search === ""){

    $stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ? AND status = 'completed' ");
    $stmt->bind_param("i" , $user_id);
    }

    else{

        $searchTerm = "%" . $search . "%";

        $stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ? AND status = 'completed' AND (title LIKE ? OR description LIKE ?)");           
        $stmt ->bind_param("iss" , $user_id , $searchTerm , $searchTerm);

    }

    }


else {
    $stmt = $conn ->prepare("SELECT * FROM tasks WHERE user_id = ?");
    $stmt->bind_param("i" , $user_id);
}

$stmt->execute();

$result = $stmt->get_result();
 
 
 
 
 ?>
<!-- Header  -->
<header>

    <div class="main-header">

        <a href="dashboard.php"><img href="sdfsdf.com" src="./assets/logo.png" alt="" class="logo"></a>
        
        <div class="header-btn">
            <img src="assets/uploads/<?php echo htmlspecialchars($user["pfp"]); ?>" alt="" class="h-pfp">
            <a class="sett-icon" href="settings.php"><svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect width="40" height="40" rx="12" fill="#F0F0F5"/>
<g clip-path="url(#clip0_1_196)">
<path fill-rule="evenodd" clip-rule="evenodd" d="M20 16.25C17.9289 16.25 16.25 17.9289 16.25 20C16.25 22.0711 17.9289 23.75 20 23.75C22.0711 23.75 23.75 22.0711 23.75 20C23.7478 17.9298 22.0702 16.2522 20 16.25ZM20 22.5C18.6193 22.5 17.5 21.3807 17.5 20C17.5 18.6193 18.6193 17.5 20 17.5C21.3807 17.5 22.5 18.6193 22.5 20C22.5 21.3807 21.3807 22.5 20 22.5ZM26.875 20.1687C26.8781 20.0562 26.8781 19.9438 26.875 19.8313L28.0406 18.375C28.1646 18.2199 28.2075 18.0152 28.1562 17.8234C27.9652 17.1052 27.6793 16.4155 27.3062 15.7727C27.2072 15.6021 27.0334 15.4883 26.8375 15.4656L24.9844 15.2594C24.9073 15.1781 24.8292 15.1 24.75 15.025L24.5312 13.1672C24.5084 12.9711 24.3943 12.7973 24.2234 12.6984C23.5803 12.3261 22.8907 12.0405 22.1727 11.8492C21.9807 11.7982 21.776 11.8414 21.6211 11.9656L20.1687 13.125C20.0562 13.125 19.9438 13.125 19.8313 13.125L18.375 11.9617C18.2199 11.8378 18.0152 11.7949 17.8234 11.8461C17.1053 12.0375 16.4157 12.3233 15.7727 12.6961C15.6021 12.7951 15.4883 12.9689 15.4656 13.1648L15.2594 15.0211C15.1781 15.0987 15.1 15.1768 15.025 15.2555L13.1672 15.4688C12.9711 15.4916 12.7973 15.6057 12.6984 15.7766C12.3261 16.4197 12.0405 17.1093 11.8492 17.8273C11.7982 18.0193 11.8414 18.224 11.9656 18.3789L13.125 19.8313C13.125 19.9438 13.125 20.0562 13.125 20.1687L11.9617 21.625C11.8378 21.7801 11.7949 21.9848 11.8461 22.1766C12.0372 22.8948 12.323 23.5845 12.6961 24.2273C12.7951 24.3979 12.9689 24.5117 13.1648 24.5344L15.018 24.7406C15.0956 24.8219 15.1737 24.9 15.2523 24.975L15.4688 26.8328C15.4916 27.0289 15.6057 27.2027 15.7766 27.3016C16.4197 27.6739 17.1093 27.9595 17.8273 28.1508C18.0193 28.2018 18.224 28.1586 18.3789 28.0344L19.8313 26.875C19.9438 26.8781 20.0562 26.8781 20.1687 26.875L21.625 28.0406C21.7801 28.1646 21.9848 28.2075 22.1766 28.1562C22.8948 27.9652 23.5845 27.6793 24.2273 27.3062C24.3979 27.2072 24.5117 27.0334 24.5344 26.8375L24.7406 24.9844C24.8219 24.9073 24.9 24.8292 24.975 24.75L26.8328 24.5312C27.0289 24.5084 27.2027 24.3943 27.3016 24.2234C27.6739 23.5803 27.9595 22.8907 28.1508 22.1727C28.2018 21.9807 28.1586 21.776 28.0344 21.6211L26.875 20.1687ZM25.6172 19.6609C25.6305 19.8868 25.6305 20.1132 25.6172 20.3391C25.6079 20.4937 25.6563 20.6463 25.7531 20.7672L26.8617 22.1523C26.7345 22.5566 26.5716 22.9488 26.375 23.3242L24.6094 23.5242C24.4556 23.5413 24.3136 23.6148 24.2109 23.7305C24.0606 23.8996 23.9004 24.0598 23.7312 24.2102C23.6156 24.3129 23.5421 24.4548 23.525 24.6086L23.3289 26.3727C22.9535 26.5694 22.5613 26.7323 22.157 26.8594L20.7711 25.7508C20.6602 25.6622 20.5224 25.614 20.3805 25.6141H20.343C20.1171 25.6273 19.8907 25.6273 19.6648 25.6141C19.5102 25.6048 19.3577 25.6532 19.2367 25.75L17.8477 26.8594C17.4434 26.7322 17.0512 26.5693 16.6758 26.3727L16.4758 24.6094C16.4587 24.4556 16.3852 24.3136 16.2695 24.2109C16.1004 24.0606 15.9402 23.9004 15.7898 23.7312C15.6871 23.6156 15.5452 23.5421 15.3914 23.525L13.6273 23.3281C13.4306 22.9527 13.2677 22.5606 13.1406 22.1562L14.2492 20.7703C14.346 20.6494 14.3945 20.4968 14.3852 20.3422C14.3719 20.1163 14.3719 19.8899 14.3852 19.6641C14.3945 19.5094 14.346 19.3569 14.2492 19.2359L13.1406 17.8477C13.2678 17.4434 13.4307 17.0512 13.6273 16.6758L15.3906 16.4758C15.5444 16.4587 15.6864 16.3852 15.7891 16.2695C15.9394 16.1004 16.0996 15.9402 16.2688 15.7898C16.3849 15.6871 16.4587 15.5448 16.4758 15.3906L16.6719 13.6273C17.0473 13.4306 17.4394 13.2677 17.8438 13.1406L19.2297 14.2492C19.3506 14.346 19.5032 14.3945 19.6578 14.3852C19.8837 14.3719 20.1101 14.3719 20.3359 14.3852C20.4906 14.3945 20.6431 14.346 20.7641 14.2492L22.1523 13.1406C22.5566 13.2678 22.9488 13.4307 23.3242 13.6273L23.5242 15.3906C23.5413 15.5444 23.6148 15.6864 23.7305 15.7891C23.8996 15.9394 24.0598 16.0996 24.2102 16.2688C24.3129 16.3844 24.4548 16.4579 24.6086 16.475L26.3727 16.6711C26.5694 17.0465 26.7323 17.4387 26.8594 17.843L25.7508 19.2289C25.653 19.3509 25.6045 19.505 25.6148 19.6609H25.6172Z" fill="#121217"/>
</g>
<defs>
<clipPath id="clip0_1_196">
<rect width="20" height="20" fill="white" transform="translate(10 10)"/>
</clipPath>
</defs>
</svg>
    
</a>
</header>

<!--    sidebar      -->

<div class="main">

<div class="sidebar">
    <h1 class="heading">TaskMaster</h1>
    <?php
        $currenPage = basename($_SERVER["PHP_SELF"]);
    ?>
    <div class="menu">
        <a href="taskmaster.php" class="item"> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1c1c1c" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-house-icon lucide-house"><path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/><path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg> Dashboard</a>
        <a href="dashboard.php" class="item <?php echo $currenPage === 'dashboard.php' ? 'active' : '';?> "> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1c1c1c" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-list-sort-ascending-icon lucide-list-sort-ascending"><path d="M3 19h18"/><path d="M15 12H3"/><path d="M9 5H3"/></svg> Tasks</a>
        <a href="settings.php" class="item <?php echo $currenPage === 'settings.php' ? 'active' : '';?> "> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1c1c1c" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bolt-icon lucide-bolt"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><circle cx="12" cy="12" r="4"/></svg> Settings</a>
    </div>
    <p class="logp">If you want to <a class="logt" href="logout.php">Logout</a> </p>

</div>

    <div class="tasks">
        <div class="tasks-header">
            <h3 class="title">My Tasks</h3>
                <button id="btn" class="addtask-btn">New Task</button>
        </div>

        <!--   titles      -->

                <div class="task-titles">
            <button   data-filter="all" class="taskt <?php echo $filter === "all" ? 'active' : '';?>">All</button>
            <button  data-filter="today" class="taskt <?php echo $filter === "today" ? 'active' : ''; ?>">Today</button>
            <button data-filter="upcoming"  class="taskt <?php echo $filter === "upcoming" ? 'active' : ''; ?> " >Upcoming</button>
            <button data-filter="completed"  class="taskt <?php echo $filter === "completed" ? 'active' : ''; ?>">Completed</button>
            
    </div>


<!----------------------- TASK LIST -->

        <div class="list">
        <div class="search-box">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#636387" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search-icon lucide-search"><path d="m21 21-4.34-4.34"/><circle cx="11" cy="11" r="8"/></svg>        <input type="search" id="search" name="search" placeholder="Search tasks" value="<?php echo htmlspecialchars($search); ?>" class="search">

        </div>

        <!--    TASK LIST     -->

        <div class="list1">
            <?php while ($task = $result->fetch_assoc()) { ?>

        <div class="inpt">
            <div class="inptl">
                
                <div class="txt">
                    <h4 class="h4l">
                    <?php echo $task["title"]; ?>
                </h4>

                <p class="pl">
                    <?php echo $task["description"]; ?>
                </p>
                </div>
                <div class="icons">
                <svg xmlns="http://www.w3.org/2000/svg" data-id="<?php echo $task["id"]; ?>" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ff2929" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-x-icon lucide-badge-x delete "><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><line x1="15" x2="9" y1="9" y2="15"/><line x1="9" x2="15" y1="9" y2="15"/></svg>
                <input type="checkbox"data-id="<?php echo $task["id"]; ?>" <?php echo $task["status"] === "completed" ? "checked" : "";?>>
                </div>
              

            </div>
        </div>

    <?php } ?>
 
        </div>

    </div>

    </div>


</div>
<script>

   const btn = document.getElementById('btn')

   btn.onclick = function(){
        window.location.href = "add.php"
   }



const checkboxes = document.querySelectorAll('input[type="checkbox"]');

checkboxes.forEach(function(checkbox) {

    checkbox.addEventListener('change', function() {

        const taskId = this.dataset.id;
        const status = this.checked ? "completed" : "pending";

        fetch("update_task.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `task_id=${taskId}&status=${status}`
        });

    });

});



    const filters = document.querySelectorAll(".taskt")

    filters.forEach(function(filter){
        filter.addEventListener("click" , function(){
            const filtername = this.dataset.filter
            window.location.href= `dashboard.php?filter=${filtername}`
        })
    })


        // search

        const search = document.getElementById("search")

        search.addEventListener("keydown" , function(event){
            if(event.key ==="Enter"){
              const searchValue = this.value  
              
              const params = new URLSearchParams(window.location.search)

              const filter = params.get("filter") || "all"

              window.location.href = `dashboard.php?filter=${filter}&search=${searchValue}`
            }
        })

            // ===========    delete button     ===============

                // =========== DELETE BUTTON ===============

const deleteButtons = document.querySelectorAll(".delete")

deleteButtons.forEach(function(button) {

    button.addEventListener("click", function() {

        const taskid = this.dataset.id;

        console.log(taskid);

        fetch("delete-task.php", {
            method: "POST",

            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },

            body: `task_id=${taskid}`
        })
        .then(function(response) {

            if (response.ok) {

                const taskCard = button.closest(".inpt")

                taskCard.remove()

            }

        })

    })

})


</script>
</body>
</html>
