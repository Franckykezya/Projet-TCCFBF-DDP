<?php

//fetch.php

$connect = new PDO("mysql:host=localhost;dbname=bdd_tccfbf_ddp", "root", "");

$column = array('nom', 'part_finance', 'maturite_facilite', 'periode_grace', 'differentiel_interet', 'frais_gestion', 'commission_engagement', 'commission_service', 'commission_initiale', 'commission_arrangement', 'commission_agent', 'maturite_lettre_credit', 'frais_lies_lettre_credit', 'frais_lies_refinancement', 'frais_et_debours', 'prime_assurance_et_frais_garantie', 'prime_attenuation_risque_credit', 'elementdon', 'tauxinteret_id');

$query = "SELECT * FROM bailleur ";


if(isset($_POST['search']['value']))
{
    $query .= '
        WHERE nom LIKE "%'.$_POST['search']['value'].'%" 
        OR part_finance LIKE "%'.$_POST['search']['value'].'%" 
        OR maturite_facilite LIKE "%'.$_POST['search']['value'].'%" 
        OR periode_grace LIKE "%'.$_POST['search']['value'].'%" 
        OR differentiel_interet LIKE "%'.$_POST['search']['value'].'%" 
        OR frais_gestion LIKE "%'.$_POST['search']['value'].'%" 
        OR commission_engagement LIKE "%'.$_POST['search']['value'].'%" 
        OR commission_service LIKE "%'.$_POST['search']['value'].'%" 
        OR commission_initiale LIKE "%'.$_POST['search']['value'].'%" 
        OR commission_arrangement LIKE "%'.$_POST['search']['value'].'%" 
        OR commission_agent LIKE "%'.$_POST['search']['value'].'%" 
        OR maturite_lettre_credit LIKE "%'.$_POST['search']['value'].'%" 
        OR frais_lies_lettre_credit LIKE "%'.$_POST['search']['value'].'%" 
        OR frais_lies_refinancement "%'.$_POST['search']['value'].'%" 
        OR frais_et_debours LIKE "%'.$_POST['search']['value'].'%" 
        OR prime_assurance_et_frais_garantie LIKE "%'.$_POST['search']['value'].'%" 
        OR prime_attenuation_risque_credit LIKE "%'.$_POST['search']['value'].'%" 
        OR elementdon LIKE "%'.$_POST['search']['value'].'%" 
        OR tauxinteret_id LIKE "%'.$_POST['search']['value'].'%" 
    ';
}

if(isset($_POST['order']))
{
    $query .= 'ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
}
else
{
    $query .= 'ORDER BY id DESC ';
}

$query1 = '';

if($_POST['length'] != -1)
{
    $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $connect->prepare($query);

$statement->execute();

$number_filter_row = $statement->rowCount();

$statement = $connect->prepare($query . $query1);

$statement->execute();

$result = $statement->fetchAll();

$data = array();

foreach($result as $row)
{
    $sub_array = array();
    $sub_array[] = $row['nom'];
    $sub_array[] = $row['part_finance'];
    $sub_array[] = $row['maturite_facilite'];
    $sub_array[] = $row['periode_grace'];
    $sub_array[] = $row['differentiel_interet'];
    $sub_array[] = $row['frais_gestion'];
    $sub_array[] = $row['commission_engagement'];
    $sub_array[] = $row['commission_service'];
    $sub_array[] = $row['commission_initiale'];
    $sub_array[] = $row['commission_arrangement'];
    $sub_array[] = $row['commission_agent'];
    $sub_array[] = $row['maturite_lettre_credit'];
    $sub_array[] = $row['frais_lies_lettre_credit'];
    $sub_array[] = $row['frais_lies_refinancement'];
    $sub_array[] = $row['frais_et_debours'];
    $sub_array[] = $row['prime_assurance_et_frais_garantie'];
    $sub_array[] = $row['prime_attenuation_risque_credit'];
    $sub_array[] = $row['elementdon'];
    $sub_array[] = $row['tauxinteret_id'];
  
    $data[] = $sub_array;
}

function count_all_data($connect)
{
    $query = "SELECT * FROM bailleur";
    $statement = $connect->prepare($query);
    $statement->execute();
    return $statement->rowCount();
}

$output = array(
    'draw'    => intval($_POST['draw']),
    'recordsTotal'  => count_all_data($connect),
    'recordsFiltered' => $number_filter_row,
    'data'    => $data
);

echo json_encode($output);

?>