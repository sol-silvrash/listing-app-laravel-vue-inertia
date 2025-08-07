function themeSwitch() {
    document.documentElement.classList.toggle("dark");
    if (document.documentElement.classList.contains("dark")) {
        localStorage.theme = "dark"
    } else {
        localStorage.theme = "light"
    }
}

function init_theme() {
    const prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
    const storedTheme = localStorage.theme;

    document.documentElement.classList.toggle(
        "dark",
        storedTheme === "dark" ||
        (!("theme" in localStorage) && prefersDark)
    )
}

export { init_theme, themeSwitch }