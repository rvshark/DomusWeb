function verification(ao_form){
  //Contrôle du prénom    
  if(ao_form.prenom.value == '') {
    alert('Veuillez renseigner votre prénom !');
    ao_form.prenom.focus();
    return false;
  }
  //Contrôle du nom
  if(ao_form.nom.value == '')  {
    alert('Veuillez renseigner votre nom !');
    ao_form.nom.focus();
    return false;
  }
  //Contrôle de l'email
  if(ao_form.email.value == '') {
    alert('Veuillez renseigner votre adresse electronique !');
    ao_form.email.focus();
    return false;
  }
  //Contrôle de l'objet du mail
  if(ao_form.objet.value == '') {
    alert('Veuillez entrer l\'objet de votre message !');
    ao_form.objet.focus();
    return false;
  }
  //Contrôle du message du maila
  if(ao_form.message.value == '') {
    alert('Veuillez entrer votre message !');
    ao_form.message.focus();
    return false;
  }
  return true;  
}