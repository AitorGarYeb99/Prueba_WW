import React, { useState, useEffect } from 'react';

function App() {
  const [restaurants, setRestaurants] = useState([]);
  const [form, setForm] = useState({ id: null, name: '', address: '', phone: '' });

  //const API_URL = 'http://localhost:8000/api/restaurants';
  const API_URL = '/api/restaurants';


  // Leer todos los restaurantes al cargar
  useEffect(() => {
    fetch(API_URL, { headers: { 'X-API-KEY': '12345' } })
      .then(res => res.json())
      .then(data => setRestaurants(data))
      .catch(err => {
        console.error('Error al cargar restaurantes:', err);
        alert('No se pudieron cargar los restaurantes.');
      });
  }, []);

  // Manejar cambios del formulario
  const handleChange = e => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  // Crear o actualizar restaurante
  const handleSubmit = e => {
    e.preventDefault();

    // Validación de campos
    if (!form.name || !form.address || !form.phone) {
      alert('Todos los campos son obligatorios.');
      return;
    }

    const method = form.id ? 'PUT' : 'POST';
    const url = form.id ? `${API_URL}/${form.id}` : API_URL;

    const body = {
      name: form.name,
      address: form.address,
      phone: form.phone,
    };

    fetch(url, {
      method,
      headers: {
        'Content-Type': 'application/json',
        'X-API-KEY': '12345',
      },
      body: JSON.stringify(body),
    })
      .then(res => {
        if (!res.ok) throw new Error('Error en la solicitud');
        return res.json();
      })
      .then(data => {
        if (method === 'POST') {
          setRestaurants([...restaurants, data]);
        } else {
          setRestaurants(restaurants.map(r => (r.id === data.id ? data : r)));
        }
        setForm({ id: null, name: '', address: '', phone: '' });
      })
      .catch(err => {
        console.error('Error al guardar restaurante:', err);
        alert('No se pudo guardar el restaurante.');
      });
  };

  // Eliminar restaurante
  const deleteRestaurant = id => {
    if (!window.confirm('¿Estás seguro de que quieres eliminar este restaurante?')) return;

    fetch(`${API_URL}/${id}`, {
      method: 'DELETE',
      headers: { 'X-API-KEY': '12345' },
    })
      .then(() => {
        setRestaurants(restaurants.filter(r => r.id !== id));
      })
      .catch(err => {
        console.error('Error al eliminar restaurante:', err);
        alert('No se pudo eliminar el restaurante.');
      });
  };

  // Cargar restaurante en el formulario para editar
  const startEdit = restaurant => {
    setForm(restaurant);
  };

  return (
    <div style={{ padding: '20px', fontFamily: 'Arial, sans-serif' }}>
      <h1>Restaurantes</h1>
      <ul>
        {restaurants.map(r => (
          <li key={r.id}>
            {r.name} - {r.address} - {r.phone}
            <button onClick={() => startEdit(r)} style={{ marginLeft: '10px' }}>Editar</button>
            <button onClick={() => deleteRestaurant(r.id)} style={{ marginLeft: '5px' }}>Eliminar</button>
          </li>
        ))}
      </ul>

      <h2>{form.id ? 'Editar Restaurante' : 'Añadir Restaurante'}</h2>
      <form onSubmit={handleSubmit}>
        <input name="name" value={form.name} onChange={handleChange} placeholder="Nombre" required />
        <input name="address" value={form.address} onChange={handleChange} placeholder="Dirección" required />
        <input name="phone" value={form.phone} onChange={handleChange} placeholder="Teléfono" required />
        <button type="submit" style={{ marginLeft: '10px' }}>
          {form.id ? 'Actualizar' : 'Crear'}
        </button>
      </form>
    </div>
  );
}

export default App;
