const themeSwitcherButton = document.querySelector("#theme-switcher")

const getThemeFromLocalStorage = () => {
  if (localStorage.getItem("amaclonColorScheme")) {
    return localStorage.getItem("amaclonColorScheme")
  }
  return "auto"
}

const getPreferedColorScheme = () => {
  return window.matchMedia("(prefers-color-scheme: dark)").matches
    ? "dark"
    : "light"
}

const setScheme = (scheme) => {
  document.querySelector("html").setAttribute("data-theme", scheme)
  localStorage.setItem("amaclonColorScheme", scheme)
}

const initScheme = () => {
  const scheme = getThemeFromLocalStorage()
  if (scheme === "auto") {
    getPreferedColorScheme === "dark" ? setScheme("dark") : setScheme("light")
  }
  if (scheme === "dark" || scheme === "light") {
    setScheme(scheme)
  }
}

themeSwitcherButton.addEventListener("click", () => {
  const selectedScheme = document
    .querySelector("html")
    .getAttribute("data-theme")
  if (selectedScheme === "light") {
    setScheme("dark")
  } else {
    setScheme("light")
  }
})

initScheme()
