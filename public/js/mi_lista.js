function activarBotonesMiLista() {
  document.querySelectorAll(".btn-mi-lista").forEach((btn) => {
    btn.onclick = async (e) => {
      e.preventDefault();
      e.stopPropagation();

      const idContenido = btn.dataset.id;

      const res = await fetch(
        "/proyecto-final-main/app/controllers/MiListaController.php",
        {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ id_contenido: idContenido }),
        }
      );

      const data = await res.json();

      if (data.status === "added") {
        btn.textContent = "✓ En mi lista";
        btn.classList.add("active");
      }

      if (data.status === "removed") {
        btn.textContent = "+ Mi lista";
        btn.classList.remove("active");

        if (window.location.search.includes("filtro=mi_lista")) {
          refrescarMiLista();
        }
      }
    };
  });
}

async function refrescarMiLista() {
  const res = await fetch(
    "/proyecto-final-main/app/controllers/MiListaController.php"
  );
  const data = await res.json();

  const grid = document.getElementById("catalogo-grid");
  if (!grid) return;

  grid.innerHTML = "";

  if (data.length === 0) {
    grid.innerHTML = "<p style='color:#aaa'>Tu lista está vacía</p>";
    return;
  }

  data.forEach((p) => {
    grid.innerHTML += `
      <div class="contenido-item" data-title="${p.titulo}">
        <a href="reproductor.php?id=${p.id_contenido}">
          <img src="../../public/img/${p.imagen}">
        </a>
        <button class="btn-mi-lista active" data-id="${p.id_contenido}">
          ✓ En mi lista
        </button>
      </div>
    `;
  });

  activarBotonesMiLista();
}

document.addEventListener("DOMContentLoaded", activarBotonesMiLista);
