const preloader = document.getElementById('preloader');

preloader.style.display = 'flex';
window.onload = () => {
    // Send the user object to the server
    fetch(`${API_URL}/user/`, {
        method: 'GET',
        headers: {
            Authorization: `token ${token}`,
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (!data.error) {
                preloader.style.display = 'none';
                buildPage(...data);
            }
        })
        .catch((error) => {
            preloader.style.display = 'none';
            console.log(error);
            logout();
        });
};

let buildPage = (data) => {
    const { fullname, level, username, email, placement, totalHours, course } =
        data;

    document.getElementById('sidebar-name').innerText = fullname;
    document.getElementById('sidebar-level').innerText =
        level || 'No level set';
    document.getElementById('card-fullname').innerText = fullname;
    document.getElementById('card-matric').innerText = username;
    document.getElementById('card-level').innerText = level || 'No level set';
    document.getElementById('card-email').innerText = email;
    document.getElementById('card-placement').innerText =
        placement || 'No placement set';
    document.getElementById('card-totalHours').innerText =
        totalHours?.toFixed(2) || 'No record found';
    document.getElementById('card-program').innerText = course;
};
