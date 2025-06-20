<?php
require_once dirname(__DIR__) . '/config/database.php';
class Offers
{
    private $id;
    private $title;
    private $description;
    private $mission;
    private $location;
    private $category;
    private $employment_type_id;
    private $technologies;
    private $benefits;
    private int $participants_count;
    private $created_at;
    private $image_url;
    private $id_company;

    public function __construct(){}

public function findAll($pdo)
{
    $query = "SELECT * FROM `offers`";
    $pdostmt = $pdo->prepare($query);
    $pdostmt->execute();

    return $pdostmt->fetchAll(PDO::FETCH_ASSOC);
}



    public function addOffers($pdo)
    {

        $query = "
        INSERT INTO job_offers (title, description, mission, location, category, id_company, employment_type_id, technologies_used, benefits, created_at, image_url)
        VALUES ( :titre, :description, :mission, :adresse, :poste, :id_company, :contrat, :technologie, :positif, :dateCreation, :imageUrl)";

        $pdostmt = $pdo->prepare($query);

        $pdostmt->execute([
            ":titre" => $this->title,
            ":description" => $this->description,
            ":mission" => $this->mission,
            ":adresse" => $this->location,
            ":poste" => $this->category,
            ":id_company" => $this->id_company,
            ":contrat" => $this->employment_type_id,
            ":technologie" => $this->technologies,
            ":positif" => $this->benefits,
            ":dateCreation" => $this->created_at,
            ":imageUrl" => $this->image_url
        ]);
    }

   public function findOfferById($pdo, $id)
    {
    $sql = "SELECT * FROM offers WHERE id = :id";
    $pdostmt = $pdo->prepare($sql);
    $pdostmt->execute(['id' => $id]);
    $offer = $pdostmt->fetch(PDO::FETCH_ASSOC);
    return $offer;
}


    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of mission
     */ 
    public function getMission()
    {
        return $this->mission;
    }

    /**
     * Set the value of mission
     *
     * @return  self
     */ 
    public function setMission($mission)
    {
        $this->mission = $mission;

        return $this;
    }

    /**
     * Get the value of location
     */ 
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set the value of location
     *
     * @return  self
     */ 
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get the value of category
     */ 
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set the value of category
     *
     * @return  self
     */ 
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get the value of employment_type_id
     */ 
    public function getEmployment_type_id()
    {
        return $this->employment_type_id;
    }

    /**
     * Set the value of employment_type_id
     *
     * @return  self
     */ 
    public function setEmployment_type_id($employment_type_id)
    {
        $this->employment_type_id = $employment_type_id;

        return $this;
    }

    /**
     * Get the value of technologies
     */ 
    public function getTechnologies()
    {
        return $this->technologies;
    }

    /**
     * Set the value of technologies
     *
     * @return  self
     */ 
    public function setTechnologies($technologies)
    {
        $this->technologies = $technologies;

        return $this;
    }

    /**
     * Get the value of benefits
     */ 
    public function getBenefits()
    {
        return $this->benefits;
    }

    /**
     * Set the value of benefits
     *
     * @return  self
     */ 
    public function setBenefits($benefits)
    {
        $this->benefits = $benefits;

        return $this;
    }

    /**
     * Get the value of participants_count
     */ 
    public function getParticipants_count()
    {
        return $this->participants_count;
    }

    /**
     * Set the value of participants_count
     *
     * @return  self
     */ 
    public function setParticipants_count($participants_count)
    {
        $this->participants_count = $participants_count;

        return $this;
    }

    /**
     * Get the value of created_at
     */ 
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of image_url
     */ 
    public function getImage_url()
    {
        return $this->image_url;
    }

    /**
     * Set the value of image_url
     *
     * @return  self
     */ 
    public function setImage_url($image_url)
    {
        $this->image_url = $image_url;

        return $this;
    }

    /**
     * Get the value of id_company
     */ 
    public function getId_company()
    {
        return $this->id_company;
    }

    /**
     * Set the value of id_company
     *
     * @return  self
     */ 
    public function setId_company($id_company)
    {
        $this->id_company = $id_company;

        return $this;
    }
}
// // if ($_SERVER["REQUEST_METHOD"] === "POST") {
//     if (
//         !empty($_POST["inputTitre"]) &&
//         !empty($_POST["inputDescription"]) &&
//         !empty($_POST["inputMission"]) &&
//         !empty($_POST["inputAdresse"]) &&
//         !empty($_POST["inputPoste"]) &&
//         !empty($_POST["inputEntreprise"]) &&
//         !empty($_POST["inputContrat"]) &&
//         !empty($_POST["inputTechnologie"]) &&
//         !empty($_POST["inputPositif"]) &&
//         !empty($_POST["inputDateCreation"]) &&
//         !empty($_POST["inputImage"])
//     ) {

//         $newOffer = new Offers(
//             htmlspecialchars($_POST["inputTitre"]),
//             htmlspecialchars($_POST["inputDescription"]),
//             htmlspecialchars($_POST["inputMission"]),
//             htmlspecialchars($_POST["inputAdresse"]),
//             htmlspecialchars($_POST["inputPoste"]),
//             htmlspecialchars($_POST["inputContrat"]),
//             htmlspecialchars($_POST["inputTechnologie"]),
//             htmlspecialchars($_POST["inputPositif"]),
//             htmlspecialchars($_POST["inputDateCreation"]),
//             htmlspecialchars($_POST["inputImage"]),
//             (int) $_POST["inputEntreprise"],
//             0,
//             null // Donc mettre aussi $id = null à la fin
//         );

//         $newOffer->addOffers($pdo);

//         header("Location: NosOffres.php");
//         exit();
//     }