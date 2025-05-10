function setThemeOnLoad() {
    if (
        localStorage.theme === "dark" ||
        (!("theme" in localStorage) && window.matchMedia("(prefers-color-scheme: dark)").matches))
    {
        document.body.classList.add('dark');
    } else {
        document.body.classList.remove('dark');
    }
}

function switchTheme() {
    if (
        localStorage.theme === "dark" ||
        (!("theme" in localStorage) && window.matchMedia("(prefers-color-scheme: dark)").matches))
    {
        document.body.classList.remove('dark');
        localStorage.theme = 'light';
    } else {
        document.body.classList.add('dark');
        localStorage.theme = 'dark';
    }
}

export { setThemeOnLoad, switchTheme}