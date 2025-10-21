create_controller:
	@read -p "Enter API folder name (e.g., Team): " folder && read -p "Enter Controller name (e.g., TeamMember): " name; \
	to_snake_case() { \
	  echo "$1" | sed -r 's/([A-Z])/_\L\1/g' | sed -r 's/^_//' ; \
	}; \
	snake_name=$$(to_snake_case "$$name"); \
	abstract_class="Abstract$$folder""Controller"; \
	controller_dir="src/Controller/Api/$$folder"; \
	controller_file="$$controller_dir/$${name}Controller.php"; \
	base_route="$$(echo "$$folder" | tr '[:upper:]' '[:lower:]')"; \
	mkdir -p "$$controller_dir"; \
	if [ -f "$$controller_file" ]; then \
	   echo "Controller '$$(basename $$controller_file)' already exists in $$controller_dir!"; \
	else \
	   printf "<?php\nnamespace App\\Controller\\Api\\%s;\n\nuse App\\Attributes\\Swagger\\Response\\Organization\\OrganizationResponse;\nuse Nelmio\\ApiDocBundle\\Attribute\\Security;\nuse Symfony\\Component\\Routing\\Attribute\\Route;\nuse OpenApi\\Attributes as OA;\n\n#[OA\\Tag(\"%s\"), Security(name: \"BearerAuth\"), Route('/%s')]\nclass %sController extends %s\n{\n    #[Route('', name: '%s_list', methods: ['GET']), OA\\Get]\n    public function index() { }\n    #[Route('', name: '%s_create', methods: ['POST']), OA\\Post]\n    public function create() { }\n    #[Route('/{id}', name: '%s_read', methods: ['GET']), OA\\Get]\n    public function read() { }\n    #[Route('/{id}', name: '%s_update', methods: ['PUT']), OA\\Put]\n    public function update() { }\n    #[Route('/{id}', name: '%s_delete', methods: ['DELETE']), OA\\Delete]\n    public function delete() { }\n}\n" "$$folder" "$$folder" "$$base_route" "$$name" "$$abstract_class" "$$snake_name" "$$snake_name" "$$snake_name" "$$snake_name" "$$snake_name" > "$$controller_file"; \
	   echo "Created Symfony controller: $$controller_file"; \
	fi


fl:
	php bin/console doctrine:fixtures:load --append


